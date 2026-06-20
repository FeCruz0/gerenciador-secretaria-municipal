<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Models\Organization;
use App\Models\SocialMedia;
use App\Models\SocialMediaUnit;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Services\UnitService;
use App\Services\UnitCreateService;
use App\Services\UnitUpdateService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Enums\Permission;

class UnitController extends Controller
{
    public function __construct(
        protected UnitService $unitService,
        protected UnitCreateService $unitCreateService,
        protected UnitUpdateService $unitUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows(Permission::VIEW_UNITS->value)) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();

            $organizations = Organization::all();
            $units = $this->unitService->get();
            return Inertia::render('Unit/Index', [
                'organizations' => $organizations,
                'units' => $units,
                'unit' => $unit
            ]);
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as Unidades Cadastradas!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function store(
        UnitRequest $request
    ){
        if (! Gate::allows(Permission::CREATE_UNITS->value)) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();

            if(isset($request['logo']) && isset($request['icon'])){
                 
                $request->validate([
                    'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
                    'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
                ]);
            
                //$path = $request->file( key:'image')->store( path: 'images/Project');
                $path_logo = Storage::disk('units')->put('logos', $request->file( key:'logo'));
                $path_icon = Storage::disk('units')->put('icons', $request->file( key:'icon'));

                $projectData = array_merge(
                    $request->toArray(),
                    [
                        'logo'  => $path_logo,
                        'icon'  => $path_icon
                    ]
                );

                $this->unitCreateService->create($projectData);
            }
            else{
                if(isset($request['icon'])){
                    
                    $request->validate([
                        'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
                    ]);
                
                    //$path = $request->file( key:'image')->store( path: 'images/Project');
                    $path_icon = Storage::disk('units')->put('icons', $request->file( key:'icon'));

                    $projectData = array_merge(
                        $request->toArray(),
                        [
                            'icon'  => $path_icon
                        ]
                    );
                    $this->unitCreateService->create($projectData);
                }else{
                    if(isset($request['logo'])){
                    
                        $request->validate([
                            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
                        ]);
                    
                        //$path = $request->file( key:'image')->store( path: 'images/Project');
                        $path_logo = Storage::disk('units')->put('logos', $request->file( key:'logo'));
    
                        $projectData = array_merge(
                            $request->toArray(),
                            [
                                'logo'  => $path_logo
                            ]
                        );
                        $this->unitCreateService->create($projectData);
                    }else{
                        $this->unitCreateService->create($request->toArray());
                    }
                }
            }


            flash('Unidade criada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao adicionar nova unidade!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function update(
        UnitRequest $request, $unit_id
    ){
        if (! Gate::allows(Permission::EDIT_UNITS->value)) {
            abort(403, 'This action is unauthorized.');
        }
        //dd($request->all());
        try {
            DB::beginTransaction();
            if(isset($request['logo']) && isset($request['icon'])){
                 
                $request->validate([
                    'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
                    'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
                ]);
            
                //$path = $request->file( key:'image')->store( path: 'images/Project');
                $path_logo = Storage::disk('units')->put('logos', $request->file( key:'logo'));
                $path_icon = Storage::disk('units')->put('icons', $request->file( key:'icon'));

                $projectData = array_merge(
                    $request->toArray(),
                    [
                        'logo'  => $path_logo,
                        'icon'  => $path_icon
                    ]
                );
                $this->unitUpdateService->update($projectData, $unit_id);
            }
            else{
                if(isset($request['icon'])){
                    
                    $request->validate([
                        'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
                    ]);
                
                    //$path = $request->file( key:'image')->store( path: 'images/Project');
                    $path_icon = Storage::disk('units')->put('icons', $request->file( key:'icon'));

                    $projectData = array_merge(
                        $request->toArray(),
                        [
                            'icon'  => $path_icon
                        ]
                    );
                    $this->unitUpdateService->update($projectData, $unit_id);
                }else{
                    if(isset($request['logo'])){
                    
                        $request->validate([
                            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
                        ]);
                    
                        //$path = $request->file( key:'image')->store( path: 'images/Project');
                        $path_logo = Storage::disk('units')->put('logos', $request->file( key:'logo'));
    
                        $projectData = array_merge(
                            $request->toArray(),
                            [
                                'logo'  => $path_logo
                            ]
                        );
                        $this->unitUpdateService->update($projectData, $unit_id);
                    }else{
                        $this->unitUpdateService->update($request->toArray(), $unit_id);
                    }
                }
            }

            flash('Unidade editada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar a unidade!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($unit_id)
    {
        if (! Gate::allows(Permission::EDIT_DEPARTMENTS->value)) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::find($unit_id);
            $organizations = Organization::all();
            $unit_selected = $this->unitService->show($unit_id);
            $unit_selected->load('about');
            $social_media = SocialMedia::all();
            return Inertia::render('Unit/Show', [
                'social_media' => $social_media,
                'unit' => $unit,
                'organizations' => $organizations,
                'unit_selected' => $unit_selected
            ]);
        } catch (\Exception $exception) {
            flash('Erro ao buscar a unidade!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($unit)
    {
        if (! Gate::allows(Permission::DELETE_UNITS->value)) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::find($unit);
            $unit->delete();
            flash('Unidade deletada com sucesso!')->success();
            return redirect('/unidades');
        } catch (\Exception $exception) {
            flash('Erro ao deletar a unidade!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function unidade_social_media_add(
        Request $request
    ){
        if (! Gate::allows(Permission::EDIT_UNITS->value)) {
            abort(403, 'This action is unauthorized.');
        }

        try {
            DB::beginTransaction();

            SocialMediaUnit::create([
                'social_media_id' => $request->social_media_id,
                'unit_id' => $request->unit_id,
                'url' => $request->url,
            ]);

            flash('Unidade editada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar a unidade!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function unidade_social_media_delete(
        $social_media
    ){
        if (! Gate::allows(Permission::EDIT_UNITS->value)) {
            abort(403, 'This action is unauthorized.');
        }

        try {
            DB::beginTransaction();
            $media = SocialMediaUnit::find($social_media);
            $media->forceDelete();
            flash('Mídia deletada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar a unidade!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function unidade_social_media_update(
        Request $request
    ){
        if (! Gate::allows(Permission::EDIT_UNITS->value)) {
            abort(403, 'This action is unauthorized.');
        }

        try {
            DB::beginTransaction();
            dd($request);
            SocialMediaUnit::where($request->id)
            ->update(['url' => $request->url]);

            flash('Unidade editada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            dd($throwable);
            flash('Erro ao editar a unidade!')->error();
            return redirect()->back()->withInput();
        }
    }
}
