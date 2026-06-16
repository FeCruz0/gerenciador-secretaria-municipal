<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConservationUnitRequest;
use App\Models\Unit;
use App\Models\ConservationUnit;
use App\Models\Coverage;
use App\Models\ConservationUnitType;
use App\Models\Gallery;
use App\Models\Leadership;
use App\Models\News;
use App\Models\Post;
use App\Models\Project;
use App\Services\PeopleService;
use App\Services\ConservationUnitService;
use App\Services\ConservationUnitCreateService;
use App\Services\ConservationUnitUpdateService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ConservationUnitController extends Controller
{
    public function __construct(
        protected ConservationUnitService $conservationUnitService,
        protected ConservationUnitCreateService $conservationUnitCreateService,
        protected ConservationUnitUpdateService $conservationUnitUpdateService,
    ){}

    public function index(): View
    {
        if (! Gate::allows('Ver e Listar Unidade de Conservacao')) {
            return view('pages.not-authorized');
        }

        try{
            $pageConfigs = ['pageHeader' => false];

            $conservation_units = ConservationUnit::all();

            return view('admin.conservation_unit.index', compact('conservation_units', 'pageConfigs'));
        } catch (\Throwable $throwable) {
            dd($throwable);
            flash('Erro ao buscar registro!')->error();
            flash('Erro ao procurar as Telefones Cadastrados!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function create(): View
    {
        if (! Gate::allows('Criar Unidade de Conservacao')) {
            return view('pages.not-authorized');
        }

        $pageConfigs = ['pageHeader' => false];

        $coverages = Coverage::all();

        return view('admin.conservation_unit.create', compact('coverages'));

    }

    public function store(
        ConservationUnitRequest $request
    ){
        if (! Gate::allows('Criar Unidade de Conservacao')) {
            return view('pages.not-authorized');
        }
        try {
            DB::beginTransaction();


            if(isset($request['thumb'])){

                $request->validate([
                    'title' => 'required',
                    'thumb' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

                $path = Storage::disk('conservation_units')->put('thumbs', $request->file( key:'thumb'));

                $conservationUnitData = array_merge(
                    $request->toArray(),
                    [
                        'thumb'  => $path,

                    ]
                );
            }
            else{

                $request->validate([
                    'title' => 'required'
                ]);

                $conservationUnitData = array_merge(
                    $request->toArray(),
                    [
                        'user_id'  => '1',
                    ]
                );

            }

            $this->conservationUnitCreateService->create($conservationUnitData);

            flash('Unidade de conServação criado com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($conservation_unit_id)
    {

        if (! Gate::allows('Ver e Listar Unidade de Conservacao')) {
            return view('pages.not-authorized');
        }

        try{
            $unit = Unit::where('web', true)->first();

            $conservation_unit = ConservationUnit::find($conservation_unit_id);
            $coverages = Coverage::all();
            $types = ConservationUnitType::all();


            $type = ConservationUnitType::orderBy('type', 'asc')->get();

            return view('admin.conservation_unit.show', compact('conservation_unit', 'types', 'coverages', 'unit' ));
        } catch (\Exception $exception) {
            flash('Erro ao buscar a Unidade!')->error();
            return redirect()->back()->withInput();
        }
    }


    public function update(
        ConservationUnitRequest $request, $conservation_unit_id
    ){
        if (! Gate::allows('Editar Unidade de Conservacao')) {
            return view('pages.not-authorized');
        }
        try {
            DB::beginTransaction();
            if(isset($request['thumb'])){

                $request->validate([
                    'title' => 'required',
                    'thumb' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

                $path = Storage::disk('conservation_units')->put('thumbs', $request->file( key:'image'));

                $data = array_merge(
                    $request->toArray(),
                    [
                        'path'  => $path
                    ]
                );
            }
            else{

                $request->validate([
                    'title' => 'required'
                ]);

                $data = array_merge(
                    $request->toArray(),
                    [
                        'user_id'  => '1'
                    ]
                );

            }
            $this->conservationUnitUpdateService->update($data, $conservation_unit_id);

            flash('Unidade de Conservação editado com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            dd($throwable);
            DB::rollBack();
            flash('Erro ao editar Unidade de Conservação!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($conservationUnit)
    {
        if (! Gate::allows('Deletar Unidade de Conservacao')) {
            return view('pages.not-authorized');
        }

        try{
            $conservationUnit = ConservationUnit::find($conservationUnit);
            $conservationUnit->delete();
            flash('Telefone deletado com sucesso!')->success();
        } catch (\Exception $exception) {
            flash('Erro ao deletar o telefone!')->error();
        }
        return redirect()->back()->withInput();
    }

    public function web_index()
    {
        try{
            $posts = Post::where('type_post_id', 1)->paginate(5)->load(['media']);
            $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
            $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
            $leaderships = Leadership::all();
            $galleries = Gallery::all();
            $unit = Unit::where('web', true)->first();
            $conservation_units = ConservationUnit::with('type')->where('status', 'PUBLISHED')->orderBy('id', 'desc')->get();

            $types = ConservationUnitType::orderBy('type', 'asc')->get();

            return view('web.unidade_de_conservacao.index', compact('posts', 'news', 'unit', 'projects', 'leaderships', 'galleries', 'conservation_units', 'types'));

        } catch (\Exception $exception) {
            flash('Erro ao deletar o telefone!')->error();
        }
    }


    public function web_show($conservation_unit_id)
    {
        $posts = Post::where('type_post_id', 1)->paginate(5)->load(['media']);
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        $unit = Unit::where('web', true)->first();
        $conservation_unit = ConservationUnit::find($conservation_unit_id);
        $conservation_units = ConservationUnit::where('status', 'PUBLISHED')->orderBy('id', 'desc')->get();
        return view('web.unidade_de_conservacao.show', compact('posts', 'news', 'unit', 'projects', 'leaderships', 'galleries', 'conservation_units', 'conservation_unit'));
    }
}
