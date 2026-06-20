<?php

namespace App\Http\Controllers;

use App\Http\Requests\DirectHireRequest;
use App\Models\Banner;
use App\Models\DirectHire;
use App\Models\DirectHireFile;
use App\Models\DirectHireModality;
use App\Models\DirectHireSituations;
use App\Models\DirectHireWinner;
use App\Models\Gallery;
use App\Models\Leadership;
use App\Models\News;
use App\Models\People;
use App\Models\Project;
use App\Models\TypeRequest;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Services\DirectHireService;
use App\Services\DirectHireCreateService;
use App\Services\DirectHireUpdateService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Inertia\Inertia;
use App\Enums\Permission;

class DirectHireController extends Controller
{
    public function __construct(
        protected DirectHireService $directHireService,
        protected DirectHireCreateService $directHireCreateService,
        protected DirectHireUpdateService $directHireUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows(Permission::VIEW_DIRECT_HIRES->value)) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();

            $direct_hires = DirectHire::with('modality')
                                        ->latest()
                                        ->get();
            return Inertia::render('DirectHire/Index', [
                'direct_hires' => $direct_hires,
                'unit' => $unit,
            ]);
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as Contratações Diretas Cadastradas!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function create()
    {
        if (! Gate::allows(Permission::CREATE_DIRECT_HIRES->value)) {
            abort(403, 'This action is unauthorized.');
        }

        $unit = Unit::where('web', true)->first();

        $modalities = DirectHireModality::with('directHires')->orderBy('title', 'asc')->get();
        $situations = DirectHireSituations::with('directHires')->orderBy('title', 'asc')->get();

        return Inertia::render('DirectHire/Create', [
            'modalities' => $modalities,
            'situations' => $situations,
            'unit' => $unit,
        ]);
    }

    public function store(
        DirectHireRequest $request
    ){
        if (! Gate::allows(Permission::CREATE_DIRECT_HIRES->value)) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();
            $fileData = array_merge(
                $request->toArray(),
                [
                    'login'  => 0
                ]
            );
            $this->directHireCreateService->create($fileData);
            
            flash('Contratação Direta criada com sucesso!')->success();
            DB::commit();
            return redirect()->route('contratacoes_diretas.index');
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($id)
    {
        if (! Gate::allows(Permission::VIEW_DIRECT_HIRES->value)) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();
            $direct_hire = DirectHire::with(['winners.person.emails', 'winners.person.documents', 'files', 'items'])->find($id);
            $direct_hires = DirectHire::with('modality')
                                        ->latest()
                                        ->get();
            $possible_winners = People::whereDoesntHave('departaments')
                                        ->orderBy('full_name', 'asc')
                                        ->get();
            $modalities = DirectHireModality::with('directHires')->orderBy('title', 'asc')->get();
            $situations = DirectHireSituations::with('directHires')->orderBy('title', 'asc')->get();

            return Inertia::render('DirectHire/Show', [
                'direct_hire' => $direct_hire,
                'unit' => $unit,
                'direct_hires' => $direct_hires,
                'modalities' => $modalities,
                'situations' => $situations,
                'possible_winners' => $possible_winners
            ]);
        } catch (\Exception $exception) {
            flash('Erro ao buscar a Contratação Direta!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function update(
        DirectHireRequest $request, $direct_hire_id
    ){
        if (! Gate::allows(Permission::EDIT_DIRECT_HIRES->value)) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();
            $this->directHireUpdateService->update($request->toarray(), $direct_hire_id);
            
            flash('Contratação Direta editada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar!')->error();
            return redirect()->back()->withInput();
        }
    }

    //site
    

    public function index_web(): View
    {
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 10)->first();
        $type_requests = TypeRequest::all();
        
        $direct_hires = DirectHire::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(10);
        $modalities = DirectHireModality::all();
        $situations = DirectHireSituations::all();
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        return view('web.directHire.index', compact('banner', 'direct_hires', 'modalities', 'situations', 'unit', 'type_requests', 'news', 'projects', 'leaderships', 'galleries'));
    }

    public function web_index_filter(Request $request)
    {
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 10)->first();
        $type_requests = TypeRequest::all();
        $modalities = DirectHireModality::all();
        $situations = DirectHireSituations::all();
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        $direct_hires = DirectHire::filter($request->all())->where('status', 'PUBLISHED')->paginate(5);
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        return view('web.directHire.index', compact('banner', 'direct_hires', 'modalities', 'situations', 'unit', 'type_requests', 'news', 'projects', 'leaderships', 'galleries'));
    }

    public function show_web($direct_hire_id)
    {
        try{
            $unit = Unit::where('web', true)->first();
            $type_requests = TypeRequest::all();
            $direct_hire = $this->directHireService->show($direct_hire_id);
            $direct_hire_files = DirectHireFile::where('direct_hire_id', $direct_hire->id)->paginate(10);
            $direct_hire_winners = DirectHireWinner::where('direct_hire_id', $direct_hire->id)->paginate(10);
            $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
            $leaderships = Leadership::all();
            $galleries = Gallery::all();
            $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
            return view('web.directHire.show', compact('direct_hire', 'direct_hire_files', 'direct_hire_winners', 'unit', 'type_requests', 'news', 'projects', 'leaderships', 'galleries'));
        } catch (\Throwable $throwable) {
            flash('Erro ao buscar registro!')->error();
            return redirect()->back()->withInput();
        }
    }
}
