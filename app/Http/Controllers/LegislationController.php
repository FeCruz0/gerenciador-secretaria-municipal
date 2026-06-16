<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Legislation;
use App\Http\Requests\LegislationRequest;
use App\Models\Banner;
use App\Models\Departament;
use App\Models\Gallery;
use App\Models\Leadership;
use App\Models\LegislationAuthor;
use App\Models\LegislationCategory;
use App\Models\LegislationSituation;
use App\Models\LegislationSubject;
use App\Models\News;
use App\Models\Project;
use App\Models\TypeRequest;
use App\Models\Unit;
use App\Services\LegislationService;
use App\Services\LegislationCreateService;
use App\Services\LegislationUpdateService;
use App\Services\LegislationBondCreateService;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class LegislationController extends Controller
{
    
    public function __construct(
        protected LegislationService $legislationService,
        protected LegislationCreateService $legislationCreateService,
        protected LegislationUpdateService $legislationUpdateService,
        protected LegislationBondCreateService $legislationBondCreateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Ver e Listar Legislações')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $pageConfigs = ['pageHeader' => false];
            $unit = Unit::where('web', true)->first();

            $legislations = Legislation::with('category', 'situation', 'subjects')
                                        ->latest()
                                        ->get();
            $categories = LegislationCategory::with('legislations')->orderBy('category', 'asc')->get();
            $situations = LegislationSituation::with('legislations')->orderBy('situation', 'asc')->get();
            return Inertia::render('Legislation/Index', [
                'legislations' => $legislations,
                'categories' => $categories,
                'situations' => $situations,
                'unit' => $unit,
            ]);
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as Assuntos Cadastrados!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function create()
    {
        if (! Gate::allows('Editar Legislações')) {
            abort(403, 'This action is unauthorized.');
        }

        $pageConfigs = ['pageHeader' => false];
        $unit = Unit::where('web', true)->first();

        $categories = LegislationCategory::with('legislations')->orderBy('category', 'asc')->get();
        $situations = LegislationSituation::with('legislations')->orderBy('situation', 'asc')->get();
        $authors = LegislationAuthor::all();
        $subjects = LegislationSubject::with('legislations')->orderBy('subject', 'asc')->get();
        $units = Unit::all();

        return Inertia::render('Legislation/Create', [
            'categories' => $categories,
            'situations' => $situations,
            'authors' => $authors,
            'subjects' => $subjects,
            'units' => $units,
            'unit' => $unit,
        ]);
    }

    public function store(
        LegislationRequest $request
    ){
        if (! Gate::allows('Editar Legislações')) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();
            $fileData = array_merge(
                $request->toArray(),
                [
                    'content'  => $request['ementa']
                ]
            );
            $this->legislationCreateService->create($fileData);
            
            flash('Legislação criada com sucesso!')->success();
            DB::commit();
            return redirect()->route('legislacoes.index');
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($legislation)
    {
        if (! Gate::allows('Ver e Listar Legislações')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();
            $legislation = Legislation::find($legislation);
            $categories = LegislationCategory::with('legislations')->orderBy('category', 'asc')->get();
            $situations = LegislationSituation::with('legislations')->orderBy('situation', 'asc')->get();
            $authors = LegislationAuthor::all();
            $subjects = LegislationSubject::with('legislations')->orderBy('subject', 'asc')->get();
            $units = Unit::all();
            $legislations = Legislation::with('category', 'situation', 'subjects')->latest()->get();
            return Inertia::render('Legislation/Show', [
                'legislation' => $legislation,
                'legislations' => $legislations,
                'categories' => $categories,
                'situations' => $situations,
                'authors' => $authors,
                'subjects' => $subjects,
                'units' => $units,
                'unit' => $unit,
            ]);
        } catch (\Exception $exception) {
            dd($exception);
            flash('Erro ao buscar o Tipo de Acesso!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function update(
        LegislationRequest $request, $legislation_id
    ){
        if (! Gate::allows('Editar Legislações')) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();
            $fileData = array_merge(
                $request->toArray(),
                [
                    'content'  => $request['ementa']
                ]
            );
            $this->legislationUpdateService->update($fileData, $legislation_id);
            
            flash('Legislação editada com sucesso!')->success();
            DB::commit();
            return redirect()->route('legislacoes.index');
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($legislation_id)
    {
        if (! Gate::allows('Deletar Legislações')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $legislation = Legislation::find($legislation_id);
            $legislation->delete();
            flash('Legislação deletada com sucesso!')->success();
            return redirect('/legislacoes');
        } catch (\Exception $exception) {
            dd($exception);
            flash('Erro ao deletar a Legislação!')->error();
            return redirect()->back()->withInput();
        }
    }

    //------------------------reports
    public function report_legislation_index()
    {
        if (! Gate::allows('Ver e Listar Receitas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();
            $legislations = Legislation::all();
            $categories = LegislationCategory::orderBy('category', 'asc')->get();
            $situations = LegislationSituation::orderBy('situation', 'asc')->get();
            return Inertia::render('Legislation/ReportIndex', [
                'legislations' => $legislations,
                'categories' => $categories,
                'situations' => $situations,
                'unit' => $unit,
            ]);
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar!')->error();
            return redirect()->back()->withInput();
        }
    }
    
    public function report_legislations_pdf(Request $request)
    {
        try{
            if (! Gate::allows('Ver e Listar Legislações')) {
                abort(403, 'This action is unauthorized.');
            }

            if(($request['category_id'] == '0') && ($request['situation_id'] == '0')){ 
                if($request['type'] == 'day'){ 
                    $day = date('d', strtotime($request['day']));
                    $legislations = Legislation::with(['category', 'situation'])
                    ->whereDay('created_at', $day)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Diário de Legislações";
                    $report_schedule = date('d-m-Y', strtotime($request['day']));
                }
                if($request['type'] == 'month'){
                    $month =  $request['month'];
                    $year = $request['year'];
                    $legislations = Legislation::with(['category', 'situation'])
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Mensal de Legislações";
                    $report_schedule = $month . ' - ' . $year;
                }
                if($request['type'] == 'year'){
                    $year = $request['year'];
                    $legislations = Legislation::with(['category', 'situation'])
                    ->whereYear('created_at', $year)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Anual de Legislações";
                    $report_schedule = $request['year'];
                }
                if($request['type'] == 'between'){
                    $date_start = $request['date_start'];
                    $date_end = $request['date_end'];
                    $legislations = Legislation::with(['category', 'situation'])
                    ->whereDate('created_at', '>=' , $date_start)
                    ->whereDate('created_at', '<=' , $date_end)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório de Legislações";
                    $report_schedule = $date_start . ' até ' . $date_end;
                }
            }elseif(($request['category_id'] > '0') && ($request['situation_id'] > '0')){
                if($request['type'] == 'day'){ 
                    $day = date('d', strtotime($request['day']));
                    $legislations = Legislation::with(['category', 'situation'])
                    ->where('category_id', $request['category_id'])
                    ->where('situation_id', $request['situation_id'])
                    ->whereDay('created_at', $day)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Diário de Legislações";
                    $report_schedule = date('d-m-Y', strtotime($request['day']));
                }
                if($request['type'] == 'month'){
                    $month =  $request['month'];
                    $year = $request['year'];
                    $legislations = Legislation::with(['category', 'situation'])
                    ->where('category_id', $request['category_id'])
                    ->where('situation_id', $request['situation_id'])
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Mensal de Legislações";
                    $report_schedule = $month . ' - ' . $year;
                }
                if($request['type'] == 'year'){
                    $year = $request['year'];
                    $legislations = Legislation::with(['category', 'situation'])
                    ->where('category_id',  $request['category_id'])
                    ->where('situation_id',  $request['situation_id'])
                    ->whereYear('created_at', $year)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Anual de Legislações";
                    $report_schedule = $request['year'];
                }
                if($request['type'] == 'between'){
                    $date_start = $request['date_start'];
                    $date_end = $request['date_end'];
                    $legislations = Legislation::with(['category', 'situation'])
                    ->where('category_id', $request['category_id'])
                    ->where('situation_id', $request['situation_id'])
                    ->whereDate('created_at', '>=' , $date_start)
                    ->whereDate('created_at', '<=' , $date_end)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório de Legislações";
                    $report_schedule = $date_start . ' até ' . $date_end;
                }

            }else{
                if($request['category_id'] > '0'){
                    if($request['type'] == 'day'){ 
                        $day = date('d', strtotime($request['day']));
                        $legislations = Legislation::with(['category', 'situation'])
                        ->where('category_id', $request['category_id'])
                        ->whereDay('created_at', $day)
                        ->orderBy('created_at')
                        ->get();
                        $report_title = "Relatório Diário de Legislações";
                        $report_schedule = date('d-m-Y', strtotime($request['day']));
                    }
                    if($request['type'] == 'month'){
                        $month =  $request['month'];
                        $year = $request['year'];
                        $legislations = Legislation::with(['category', 'situation'])
                        ->where('category_id', $request['category_id'])
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->orderBy('created_at')
                        ->get();
                        $report_title = "Relatório Mensal de Legislações";
                        $report_schedule = $month . ' - ' . $year;
                    }
                    if($request['type'] == 'year'){
                        $year = $request['year'];
                        $legislations = Legislation::with(['category', 'situation'])
                        ->where('category_id', $request['category_id'])
                        ->whereYear('created_at', $year)
                        ->orderBy('created_at')
                        ->get();
                        $report_title = "Relatório Anual de Legislações";
                        $report_schedule = $request['year'];
                    }
                    if($request['type'] == 'between'){
                        $date_start = $request['date_start'];
                        $date_end = $request['date_end'];
                        $legislations = Legislation::with(['category', 'situation'])
                        ->where('category_id', $request['category_id'])
                        ->whereDate('created_at', '>=' , $date_start)
                        ->whereDate('created_at', '<=' , $date_end)
                        ->orderBy('created_at')
                        ->get();
                        $report_title = "Relatório de Legislações";
                        $report_schedule = $date_start . ' até ' . $date_end;
                    }

                }
                if($request['situation_id'] > '0'){
                    if($request['type'] == 'day'){ 
                        $day = date('d', strtotime($request['day']));
                        $legislations = Legislation::with(['category', 'situation'])
                        ->where('situation_id', $request['situation_id'])
                        ->whereDay('created_at', $day)
                        ->orderBy('created_at')
                        ->get();
                        $report_title = "Relatório Diário de Legislações";
                        $report_schedule = date('d-m-Y', strtotime($request['day']));
                    }
                    if($request['type'] == 'month'){
                        $month =  $request['month'];
                        $year = $request['year'];
                        $legislations = Legislation::with(['category', 'situation'])
                        ->where('situation_id', $request['situation_id'])
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->orderBy('created_at')
                        ->get();
                        $report_title = "Relatório Mensal de Legislações";
                        $report_schedule = $month . ' - ' . $year;
                    }
                    if($request['type'] == 'year'){
                        $year = $request['year'];
                        $legislations = Legislation::with(['category', 'situation'])
                        ->where('situation_id', $request['situation_id'])
                        ->whereYear('created_at', $year)
                        ->orderBy('created_at')
                        ->get();
                        $report_title = "Relatório Anual de Legislações";
                        $report_schedule = $request['year'];
                    }
                    if($request['type'] == 'between'){
                        $date_start = $request['date_start'];
                        $date_end = $request['date_end'];
                        $legislations = Legislation::with(['category', 'situation'])
                        ->where('situation_id', $request['situation_id'])
                        ->whereDate('created_at', '>=' , $date_start)
                        ->whereDate('created_at', '<=' , $date_end)
                        ->orderBy('created_at')
                        ->get();
                        $report_title = "Relatório de Legislações";
                        $report_schedule = $date_start . ' até ' . $date_end;
                    }
                    
                }
            }

            $unit = Unit::where('web', true)->first();

            $pdf = FacadePdf::loadView('admin.legislation.report_pdf', compact('legislations', 'report_title', 'report_schedule', 'unit'));
            $pdf->setPAper('a4', 'portrait');

            return $pdf->stream('legislations.pdf');

        } catch (\Throwable $throwable) {
            flash('Não foram encontradas Legislações Cadastradas!')->error();
            dd($throwable);
            return redirect()->back()->withInput();
        }
    }

    //site
    

    public function index_web(): View
    {
        $banner = Banner::where('banner_type_id', 7)->first();
        $unit = Unit::where('web', true)->first();
        $type_requests = TypeRequest::all();
        $categories = LegislationCategory::all();
        $situations = LegislationSituation::all();
        $legislations = Legislation::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(10);
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        return view('web.legislation.index', compact('banner', 'legislations', 'categories', 'situations', 'unit', 'type_requests', 'news', 'projects', 'leaderships', 'galleries'));
    }

    public function web_index_filter(Request $request)
    {
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 7)->first();
        $type_requests = TypeRequest::all();
        $categories = LegislationCategory::all();
        $situations = LegislationSituation::all();
        $legislations = Legislation::filter($request->all())->where('status', 'PUBLISHED')->paginate(5);
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        return view('web.legislation.index', compact('banner', 'legislations', 'categories', 'situations', 'unit', 'type_requests', 'news', 'projects', 'leaderships', 'galleries'));
    }

    public function show_web($legislation_id)
    {
        try{
            $unit = Unit::where('web', true)->first();
            $type_requests = TypeRequest::all();
            $legislation = $this->legislationService->show($legislation_id);
            $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
            $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
            $leaderships = Leadership::all();
            $galleries = Gallery::all();
            return view('web.legislation.show', compact('legislation', 'unit', 'type_requests', 'news', 'projects', 'leaderships', 'galleries'));
        } catch (\Throwable $throwable) {
            flash('Erro ao buscar registro!')->error();
            return redirect()->back()->withInput();
        }
    }

}
