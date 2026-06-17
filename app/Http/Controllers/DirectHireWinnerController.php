<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DirectHireWinner;
use App\Http\Requests\DirectHireWinnerRequest;
use App\Models\Bidding;
use App\Models\City;
use App\Models\Country;
use App\Models\Genre;
use App\Models\MatrialStatus;
use App\Models\People;
use App\Models\State;
use App\Models\TypeRequest;
use App\Models\Unit;
use App\Services\PeopleService;
use App\Services\DirectHireWinnerService;
use App\Services\DirectHireWinnerCreateService;
use App\Services\DirectHireWinnerUpdateService;
use App\Services\DirectHireItemUpdateService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class DirectHireWinnerController extends Controller
{
    
    public function __construct(
        protected PeopleService $peopleService,
        protected DirectHireWinnerService $directHireWinnerService,
        protected DirectHireWinnerCreateService $directHireWinnerCreateService,
        protected DirectHireWinnerUpdateService $directHireWinnerUpdateService,
        protected DirectHireItemUpdateService $direct_hireItemUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Editar Contratações Diretas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();

            $people = People::whereDoesntHave('departaments')
                                        ->latest()
                                        ->get();
            return Inertia::render('DirectHire/WinnerIndex', [
                'people' => $people,
                'unit' => $unit,
            ]);
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as Pessoas Cadastradas!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function create()
    {
        if (! Gate::allows('Editar Contratações Diretas')) {
            abort(403, 'This action is unauthorized.');
        }

        $unit = Unit::where('web', true)->first();

        $genres = Genre::all();
        $matrial_statuses = MatrialStatus::all();
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();

        return Inertia::render('DirectHire/WinnerCreate', [
            'genres' => $genres,
            'unit' => $unit,
            'matrial_statuses' => $matrial_statuses,
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
        ]);
    }

    public function store(
        DirectHireWinnerRequest $request
    ){
        if (! Gate::allows('Editar Contratações Diretas')) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();
            $this->directHireWinnerCreateService->create($request->toArray());
            
            flash('Vencedor criado com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($winner_id)
    {
        if (! Gate::allows('Editar Contratações Diretas')) {
            abort(403, 'This action is unauthorized.');
        }
        try{
            $unit = Unit::where('web', true)->first();
            $genres = Genre::all();
            $matrial_statuses = MatrialStatus::all();
            $countries = Country::all();
            $states = State::all();
            $cities = City::all();

            $person = $this->peopleService->show($winner_id);
            $directs_hires_winner = DirectHireWinner::where('people_id', $winner_id)
                                            ->latest()
                                            ->get();
            return Inertia::render('DirectHire/WinnerShow', [
                'person' => $person,
                'unit' => $unit,
                'directs_hires_winner' => $directs_hires_winner,
                'genres' => $genres,
                'matrial_statuses' => $matrial_statuses,
                'countries' => $countries,
                'states' => $states,
                'cities' => $cities,
            ]);
        } catch (\Exception $exception) {
            flash('Erro ao buscar o Vencedor!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function update(
        DirectHireWinnerRequest $request, $winner_id
    ){
        if (! Gate::allows('Editar Contratações Diretas')) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();
            $this->directHireWinnerUpdateService->update($request->toArray(), $winner_id);
            
            flash('Vencedor editado com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($winner)
    {
        if (! Gate::allows('Editar Contratações Diretas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $for_delete = DirectHireWinner::find($winner);
            $direct_hire_id = $for_delete->direct_hire_id;
            $for_delete->delete();
            flash('Vencedor deletado com sucesso!')->success();
            return redirect()->route('contratacoes_diretas.show', $direct_hire_id);
        } catch (\Exception $exception) {
            flash('Erro ao deletar a Winner!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function winner_add_itens(
        Request $request, $person_id
    ){
        if (! Gate::allows('Editar Contratações Diretas')) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();
            
            foreach($request['items'] as $key => $item_id){
                $fileData = array(
                    "people_id" => $person_id
                );
                $this->direct_hireItemUpdateService->update($fileData, $item_id);
            }
            flash('Item editado com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function winner_remove_itens(
        Request $request
    ){
        if (! Gate::allows('Editar Contratações Diretas')) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();
            
            foreach($request['remove_items'] as $key => $item_id){
                $fileData = array(
                    "people_id" => NULL
                );
                $this->direct_hireItemUpdateService->update($fileData, $item_id);
            }
            flash('Item editado com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function winner_itens($winner_id)
    {
        if (! Gate::allows('Editar Contratações Diretas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $genres = Genre::all();
            $matrial_statuses = MatrialStatus::all();
            $countries = Country::all();
            $states = State::all();
            $cities = City::all();

            $winner_selected = DirectHireWinner::with(['directHire.items', 'person'])->find($winner_id);
            return Inertia::render('DirectHire/WinnerItems', [
                'winner_selected' => $winner_selected,
                'genres' => $genres,
                'matrial_statuses' => $matrial_statuses,
                'countries' => $countries,
                'states' => $states,
                'cities' => $cities,
            ]);
        } catch (\Exception $exception) {
            flash('Erro ao buscar o Vencedor!')->error();
            return redirect()->back()->withInput();
        }
    }
    //site
    

    public function show_web($winner_id)
    {
        try{
            $unit = Unit::where('web', true)->first();
            $type_requests = TypeRequest::all();
            $person = $this->peopleService->show($winner_id);
            return view('web.directHire.winner_show', compact('person', 'type_requests', 'unit'));
        } catch (\Throwable $throwable) {
            flash('Erro ao buscar registro!')->error();
            dd($throwable);
            return redirect()->back()->withInput();
        }
    }
}
