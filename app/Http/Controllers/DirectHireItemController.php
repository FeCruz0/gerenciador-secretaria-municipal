<?php

namespace App\Http\Controllers;

use App\Models\DirectHireItem;
use App\Http\Requests\DirectHireItemRequest;
use App\Models\DirectHire;
use App\Models\Unit;
use App\Services\DirectHireItemService;
use App\Services\DirectHireItemCreateService;
use App\Services\DirectHireItemUpdateService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class DirectHireItemController extends Controller
{
    
    public function __construct(
        protected DirectHireItemService $directHireItemService,
        protected DirectHireItemCreateService $directHireItemCreateService,
        protected DirectHireItemUpdateService $directHireItemUpdateService,
    ){}

    public function store(
        DirectHireItemRequest $request
    ){
        if (! Gate::allows('Editar Contratações Diretas')) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();
            $this->directHireItemCreateService->create($request->toArray());
            
            flash('Item criado com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($item_id)
    {
        if (! Gate::allows('Editar Contratações Diretas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();
            $item_selected = $this->directHireItemService->show($item_id);
            $directHire_id = $item_selected->direct_hire_id;
            $directHire = DirectHire::find($directHire_id);
            return Inertia::render('DirectHire/ItemShow', [
                'item_selected' => $item_selected,
                'directHire' => $directHire,
                'unit' => $unit
            ]);
        } catch (\Exception $exception) {
            flash('Erro ao buscar o Item!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function update(
        DirectHireItemRequest $request, $item_id
    ){
        if (! Gate::allows('Editar Contratações Diretas')) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();
            $this->directHireItemUpdateService->update($request->toArray(), $item_id);
            
            flash('Item editado com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($item)
    {
        if (! Gate::allows('Editar Contratações Diretas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $for_delete = DirectHireItem::find($item);
            $directHire_id = $for_delete->direct_hire_id;
            $directHire = DirectHire::find($directHire_id);
            $for_delete->delete();
            flash('Item deletado com sucesso!')->success();
            return redirect('/contratacoes_diretas/' . $directHire->id);
        } catch (\Exception $exception) {
            flash('Erro ao deletar o Item!')->error();
            return redirect()->back()->withInput();
        }
    }
}
