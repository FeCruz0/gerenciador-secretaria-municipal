<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\ExpenseRequest;
use App\Models\Banner;
use App\Models\Expense;
use App\Models\Gallery;
use App\Models\Leadership;
use App\Models\News;
use App\Models\Project;
use App\Models\TypeExpense;
use App\Models\TypeRequest;
use App\Models\Unit;
use Inertia\Inertia;
use App\Services\ExpenseService;
use App\Services\ExpenseCreateService;
use App\Services\ExpenseUpdateService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class ExpenseController extends Controller
{
    public function __construct(
        protected ExpenseService $expenseService,
        protected ExpenseCreateService $expenseCreateService,
        protected ExpenseUpdateService $expenseUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Ver e Listar Despesas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();

            $expenses = $this->expenseService->get();
            return Inertia::render('Expense/Index', [
                'expenses' => $expenses,
                'unit' => $unit,
            ]);
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as Despesas Cadastradas!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function create()
    {
        if (! Gate::allows('Editar Despesas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();

            $types = TypeExpense::orderBy('title', 'asc')->get();
            return Inertia::render('Expense/Create', [
                'types' => $types,
                'unit' => $unit,
            ]);
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as Despesas Cadastradas!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function store(
        ExpenseRequest $request
    ){
        if (! Gate::allows('Editar Despesas')) {
            abort(403, 'This action is unauthorized.');
        }
        
        
        try {
            DB::beginTransaction();
            $this->expenseCreateService->create($request->toArray());

            flash('Despesa criada com sucesso!')->success();
            DB::commit();
            return redirect()->route('despesas.index');
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao adicionar nova Despesa!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($expense_id)
    {
        if (! Gate::allows('Ver e Listar Despesas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();
            $types = TypeExpense::orderBy('title', 'asc')->get();
            $expense = $this->expenseService->show($expense_id);
            return Inertia::render('Expense/Show', [
                'expense' => $expense,
                'types' => $types,
                'unit' => $unit,
            ]);
        } catch (\Exception $exception) {
            flash('Erro ao buscar o Tipo de Receita!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function update(
        ExpenseRequest $request, $expense_id
    ){
        if (! Gate::allows('Editar Despesas')) {
            abort(403, 'This action is unauthorized.');
        }
        
        try {
            DB::beginTransaction();
            $this->expenseUpdateService->update($request->toArray(), $expense_id);

            flash('Receita editada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar a Receita!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($expense)
    {
        if (! Gate::allows('Deletar Despesas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $expenseDelete = Expense::find($expense);
            $expenseDelete->delete();

            flash('Despesa deletada com sucesso!')->success();
            return redirect()->route('despesas.index');
        } catch (\Exception $exception) {
            flash('Erro ao deletar a Receita!')->error();
            return redirect()->back()->withInput();
        }
    }

    //------------------------reports
    public function report_expense_index()
    {
        if (! Gate::allows('Ver e Listar Despesas')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $expenses = Expense::all();
            $types = TypeExpense::orderBy('title', 'asc')->get();
            return Inertia::render('Expense/ReportIndex', [
                'expenses' => $expenses,
                'types' => $types,
            ]);
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar!')->error();
            return redirect()->back()->withInput();
        }
    }
    
    public function report_expenses_pdf(Request $request)
    {
        try{
            if (! Gate::allows('Ver e Listar Despesas')) {
                abort(403, 'This action is unauthorized.');
            }

            if($request['type'] == 'day'){ 
                if($request['type_expense'] > 0){
                    $day = date('d', strtotime($request['day']));
                    $expenses = Expense::with(['typeExpense'])
                    ->where('type_expense_id','==' , $request['type_expense'])
                    ->whereDay('created_at', $day)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Diário de Despesas";
                    $report_schedule = date('d-m-Y', strtotime($request['day']));
                }else{
                    $day = date('d', strtotime($request['day']));
                    $expenses = Expense::with(['typeExpense'])
                    ->whereDay('created_at', $day)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Diário de Despesas";
                    $report_schedule = date('d-m-Y', strtotime($request['day']));
                }
            }
            if($request['type'] == 'month'){
                if($request['type_expense'] > 0){
                    $month =  $request['month'];
                    $year = $request['year'];
                    $expenses = Expense::with(['typeExpense'])
                    ->where('type_expense_id','==' , $request['type_expense'])
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Mensal de Despesas";
                    $report_schedule = $month . ' - ' . $year;
                }else{
                    $month =  $request['month'];
                    $year = $request['year'];
                    $expenses = Expense::with(['typeExpense'])
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Mensal de Despesas";
                    $report_schedule = $month . ' - ' . $year;
                }
            }
            if($request['type'] == 'year'){
                if($request['type_expense'] > 0){
                    $year = $request['year'];
                    $expenses = Expense::with(['typeExpense'])
                    ->where('type_expense_id', $request['type_expense'])
                    ->whereYear('created_at', $year)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Anual de Despesas";
                    $report_schedule = $request['year'];
                }
                else{
                    $year = $request['year'];
                    $expenses = Expense::with(['typeExpense'])
                    ->whereYear('created_at', $year)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório Anual de Despesas";
                    $report_schedule = $request['year'];
                }
            }
            if($request['type'] == 'between'){
                if($request['type_expense'] > 0){
                    $date_start = $request['date_start'];
                    $date_end = $request['date_end'];
                    $expenses = Expense::with(['typeExpense'])
                    ->where('type_expense_id','==' , $request['type_expense'])
                    ->whereDate('created_at', '>=' , $date_start)
                    ->whereDate('created_at', '<=' , $date_end)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório de Despesas";
                    $report_schedule = $date_start . ' até ' . $date_end;
                }else{
                    $date_start = $request['date_start'];
                    $date_end = $request['date_end'];
                    $expenses = Expense::with(['typeExpense'])
                    ->whereDate('created_at', '>=' , $date_start)
                    ->whereDate('created_at', '<=' , $date_end)
                    ->orderBy('created_at')
                    ->get();
                    $report_title = "Relatório de Despesas";
                    $report_schedule = $date_start . ' até ' . $date_end;
                }
            }

            $unit = Unit::where('web', true)->first();

            $pdf = FacadePdf::loadView('admin.expense.report_pdf', compact('expenses', 'report_title', 'report_schedule', 'unit'));
            $pdf->setPAper('a4', 'portrait');

            return $pdf->stream('expenses.pdf');

        } catch (\Throwable $throwable) {
            flash('Não foram encontradas Despesas Cadastradas!')->error();
            dd($throwable);
            return redirect()->back()->withInput();
        }
    }

    //-------------------------site
    

    public function web_index(Request $request){
        
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 5)->first();
        $type_requests = TypeRequest::all();
        $types = TypeExpense::all();
        $expenses = Expense::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(10);
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        return view('web.expense.index', compact('banner', 'expenses', 'types', 'unit', 'type_requests', 'news', 'projects', 'leaderships', 'galleries'));
    }

    public function web_index_filter(Request $request)
    {
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 5)->first();
        $type_requests = TypeRequest::all();
        $types = TypeExpense::all();
        $expenses = Expense::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(10);
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        return view('web.expense.index', compact('banner', 'expenses', 'types', 'unit', 'type_requests', 'news', 'projects', 'leaderships', 'galleries'));
    }

    public function web_show($expense_id)
    {
        try{
            $unit = Unit::where('web', true)->first();
            $type_requests = TypeRequest::all();
            $expense = Expense::findOrFail($expense_id);
            $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
            $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
            $leaderships = Leadership::all();
            $galleries = Gallery::all();
            return view('web.expense.show', compact('expense', 'unit', 'type_requests', 'news', 'projects', 'leaderships', 'galleries'));
        } catch (\Exception $exception) {
            session()->flash('show_expense_error', $expense['title'].' Erro ao tentar acessar! ');
            return redirect()->route('web.expenses_index');
        }
    }
}
