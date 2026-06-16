<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\CoverageRequest;
use App\Models\Banner;
use App\Models\Coverage;
use App\Models\Gallery;
use App\Models\Leadership;
use App\Models\News;
use App\Models\Project;
use App\Models\Unit;
use App\Services\CoverageService;
use App\Services\CoverageCreateService;
use App\Services\CoverageUpdateService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CoverageController extends Controller
{
    public function __construct(
        protected CoverageService $CoverageService,
        protected CoverageCreateService $CoverageCreateService,
        protected CoverageUpdateService $CoverageUpdateService,
    ){}

    public function index(): View
    {
        if (! Gate::allows('Ver e Listar Abrangencia')) {
            return view('pages.not-authorized');
        }

        try{
            $pageConfigs = ['pageHeader' => false];

            $unit = Unit::where('web', true)->first();
            $coverages = Coverage::all();
            return view('admin.conservation_unit.coverage_index', ['pageConfigs' => $pageConfigs], compact('coverages', 'unit'));
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as Coverages Cadastradas!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function create(): View
    {
        if (! Gate::allows('Criar Agrangencia')) {
            return view('pages.not-authorized');
        }
        
        $pageConfigs = ['pageHeader' => false];
        $unit = Unit::where('web', true)->first();


        return view('admin.conservation_unit.coverage_index', ['pageConfigs' => $pageConfigs], compact('unit'));

    }

    public function store(
        CoverageRequest $request
    ){
        if (! Gate::allows('Criar Abrangencia')) {
            return view('pages.not-authorized');
        }
        try {
            DB::beginTransaction();
            
            $this->CoverageCreateService->create($request->toArray());

            flash('Coverage criada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            dd($throwable);
            DB::rollBack();
            flash('Erro ao adicionar nova Cidade!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($coverage_id): View
    {
        if (! Gate::allows('Ver e Listar Abrangencia')) {
            return view('pages.not-authorized');
        }

        try{
            $coverage = Coverage::find($coverage_id);
            $coverages = Coverage::all();
            $unit = Unit::where('web', true)->first();
            return view('admin.coverage.show', compact('Coverage', 'Coverages', 'unit'));
            
        } catch (\Throwable $throwable) {
            flash('Erro ao buscar registro!')->error();
            return redirect()->back()->withInput();
        }
    }
    
    public function update(
        CoverageRequest $request, $coverage_id
    ){
        if (! Gate::allows('Editar Coverages')) {
            return view('pages.not-authorized');
        }

        try {
            DB::beginTransaction();
            $this->CoverageUpdateService->update($request->toArray(), $coverage_id);

            flash('Coverage editado com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar o Coverage!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($coverage)
    {
        if (! Gate::allows('Deletar Coverages')) {
            return view('pages.not-authorized');
        }

        try{
            $coverage = Coverage::find($coverage);
            $coverage->delete();
            flash('Coverage deletado com sucesso!')->success();
            return redirect('/Coverages');
        } catch (\Exception $exception) {
            flash('Erro ao deletar o Coverage!')->error();
            return redirect()->back()->withInput();
        }
    }
    //web
    

    public function Coverages_web_index()
    {
        $coverages = Coverage::where('status', 'PUBLISHED')->orderBy('question', 'asc')->get();
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 2)->first();
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        return view('web.Coverage.index', compact('banner', 'Coverages', 'unit', 'news', 'projects', 'leaderships', 'galleries'));
    }
}
