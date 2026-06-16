<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\RevenueRequest;
use App\Models\Banner;
use App\Models\Gallery;
use App\Models\Leadership;
use App\Models\News;
use App\Models\Project;
use App\Models\Revenue;
use App\Models\RevenueType;
use App\Models\TypeRequest;
use App\Models\Unit;
use Inertia\Inertia;
use App\Services\RevenueService;
use App\Services\RevenueCreateService;
use App\Services\RevenueUpdateService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class RevenueController extends Controller
{
    public function __construct(
        protected RevenueService $revenueService,
        protected RevenueCreateService $revenueCreateService,
        protected RevenueUpdateService $revenueUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Ver e Listar Receitas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();

            $revenues = Revenue::with('files')->latest()->get();
            return Inertia::render('Revenue/Index', [
                'revenues' => $revenues,
                'unit' => $unit,
            ]);
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as Receitas Cadastradas!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function create()
    {
        if (! Gate::allows('Editar Receitas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();

            $types = RevenueType::orderBy('title', 'asc')->get();
            return Inertia::render('Revenue/Create', [
                'types' => $types,
                'unit' => $unit,
            ]);
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as Receitas Cadastradas!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function store(
        RevenueRequest $request
    ){
        if (! Gate::allows('Editar Receitas')) {
            abort(403, 'This action is unauthorized.');
        }
        
        try {
            DB::beginTransaction();
            $revenue = $this->revenueCreateService->create($request->toArray());

            flash('Tipo de Receita criada com sucesso!')->success();
            DB::commit();
            return redirect()->route('receitas.show', [$revenue->id]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao adicionar nova Receita!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($revenue_id)
    {
        if (! Gate::allows('Ver e Listar Receitas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $types = RevenueType::orderBy('title', 'asc')->get();
            $revenue = $this->revenueService->show($revenue_id);
            return Inertia::render('Revenue/Show', [
                'revenue' => $revenue,
                'types' => $types,
            ]);
        } catch (\Exception $exception) {
            dd($exception);
            flash('Erro ao buscar a Receita!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function update(
        RevenueRequest $request, $revenue_id
    ){
        if (! Gate::allows('Editar Receitas')) {
            abort(403, 'This action is unauthorized.');
        }
        
        try {
            DB::beginTransaction();
            $this->revenueUpdateService->update($request->toArray(), $revenue_id);

            flash('Receita editada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar a Receita!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($revenue)
    {
        if (! Gate::allows('Deletar Receitas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $revenueDelete = Revenue::find($revenue);
            $revenueDelete->delete();

            flash('Receita deletada com sucesso!')->success();
            return redirect()->route('receitas.index');
        } catch (\Exception $exception) {
            flash('Erro ao deletar a Receita!')->error();
            return redirect()->back()->withInput();
        }
    }

    //------------------------reports
    public function report_revenue_index()
    {
        if (! Gate::allows('Ver e Listar Receitas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();
            $revenues = Revenue::all();
            $types = RevenueType::orderBy('title', 'asc')->get();
            return Inertia::render('Revenue/ReportIndex', [
                'revenues' => $revenues,
                'types' => $types,
                'unit' => $unit,
            ]);
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar!')->error();
            return redirect()->back()->withInput();
        }
    }
    
    public function report_revenues_pdf(Request $request)
    {
        try{
            if (! Gate::allows('Ver e Listar Receitas')) {
                abort(403, 'This action is unauthorized.');
            }

            if($request['type'] == 'day'){ 
                if($request['type_id'] > 0){
                    $day = date('d', strtotime($request['day']));
                    $revenues = Revenue::with(['type'])
                    ->where('type_id','==' , $request['type_id'])
                    ->whereDay('created_at', $day)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Diário de Receitas";
                    $report_schedule = date('d-m-Y', strtotime($request['day']));
                }else{
                    $day = date('d', strtotime($request['day']));
                    $revenues = Revenue::with(['type'])
                    ->whereDay('created_at', $day)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Diário de Receitas";
                    $report_schedule = date('d-m-Y', strtotime($request['day']));
                }
            }
            if($request['type'] == 'month'){
                if($request['type_id'] > 0){
                    $month =  $request['month'];
                    $year = $request['year'];
                    $revenues = Revenue::with(['type'])
                    ->where('type_id','==' , $request['type_id'])
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Mensal de Receitas";
                    $report_schedule = $month . ' - ' . $year;
                }else{
                    $month =  $request['month'];
                    $year = $request['year'];
                    $revenues = Revenue::with(['type'])
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Mensal de Receitas";
                    $report_schedule = $month . ' - ' . $year;
                }
            }
            if($request['type'] == 'year'){
                if($request['type_id'] > 0){
                    $year = $request['year'];
                    $revenues = Revenue::with(['type'])
                    ->where('type_id', $request['type_id'])
                    ->whereYear('created_at', $year)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Anual de Receitas";
                    $report_schedule = $request['year'];
                }
                else{
                    $year = $request['year'];
                    $revenues = Revenue::with(['type'])
                    ->whereYear('created_at', $year)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Anual de Receitas";
                    $report_schedule = $request['year'];
                }
            }
            if($request['type'] == 'between'){
                if($request['type_id'] > 0){
                    $date_start = $request['date_start'];
                    $date_end = $request['date_end'];
                    $revenues = Revenue::with(['type'])
                    ->where('type_id','==' , $request['type_id'])
                    ->whereDate('created_at', '>=' , $date_start)
                    ->whereDate('created_at', '<=' , $date_end)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório de Receitas";
                    $report_schedule = $date_start . ' até ' . $date_end;
                }else{
                    $date_start = $request['date_start'];
                    $date_end = $request['date_end'];
                    $revenues = Revenue::with(['type'])
                    ->whereDate('created_at', '>=' , $date_start)
                    ->whereDate('created_at', '<=' , $date_end)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório de Receitas";
                    $report_schedule = $date_start . ' até ' . $date_end;
                }
            }

            $unit = Unit::where('web', true)->first();

            $pdf = FacadePdf::loadView('admin.revenue.report_pdf', compact('revenues', 'report_title', 'report_schedule', 'unit'));
            $pdf->setPAper('a4', 'portrait');

            return $pdf->stream('revenues.pdf');

        } catch (\Throwable $throwable) {
            flash('Não foram encontradas Receitas Cadastradas!')->error();
            dd($throwable);
            return redirect()->back()->withInput();
        }
    }

    //site
    

    public function web_index(Request $request){
        
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 6)->first();
        $type_requests = TypeRequest::all();
        $revenues = Revenue::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(10);
        $types = RevenueType::all();
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        return view('web.revenue.index', compact('banner', 'revenues', 'types', 'unit', 'type_requests', 'news', 'projects', 'leaderships', 'galleries'));
    }

    public function web_index_filter(Request $request)
    {
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 6)->first();
        $type_requests = TypeRequest::all();
        $revenues = Revenue::filter($request->all())->where('status', 'PUBLISHED')->paginate(5);
        $types = RevenueType::all();
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        return view('web.revenue.index', compact('banner', 'revenues', 'types', 'unit', 'type_requests', 'news', 'projects', 'leaderships', 'galleries'));
    }

    public function web_show($revenue_id)
    {
        try{
            $unit = Unit::where('web', true)->first();
            $type_requests = TypeRequest::all();
            $revenue = Revenue::findOrFail($revenue_id);
            $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
            $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
            $leaderships = Leadership::all();
            $galleries = Gallery::all();
            return view('web.revenue.show', compact('revenue', 'unit', 'type_requests', 'news', 'projects', 'leaderships', 'galleries'));
        } catch (\Exception $exception) {
            session()->flash('show_revenue_error', $revenue['title'].' Erro ao tentar acessar! ');
            return redirect()->route('web.revenue_index');
        }
    }
}
