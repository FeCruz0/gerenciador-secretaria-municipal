<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\ManagementReport;
use App\Models\ManagementReportType;
use App\Http\Requests\ManagementReportRequest;
use App\Services\ManagementReportService;
use App\Services\ManagementReportCreateService;
use App\Services\ManagementReportUpdateService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ManagementReportController extends Controller
{
    public function __construct(
        protected ManagementReportService $managementReportService,
        protected ManagementReportCreateService $managementReportCreateService,
        protected ManagementReportUpdateService $managementReportUpdateService,
    ) {}

    public function index()
    {
        if (! Gate::allows('Ver e Listar Relatório de Gestão')) {
            abort(403);
        }

        try {
            $unit = Unit::where('web', true)->first();
            $management_reports = ManagementReport::with(['managementReportType', 'file'])->get();

            return Inertia::render('ManagementReport/Index', compact('management_reports', 'unit'));
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar os Relatórios de Gestão Cadastrados!')->error();
            return redirect()->back();
        }
    }

    public function create()
    {
        if (! Gate::allows('Criar Relatório de Gestão')) {
            abort(403);
        }

        try {
            $unit = Unit::where('web', true)->first();
            $management_report_types = ManagementReportType::all();

            return Inertia::render('ManagementReport/Create', compact('management_report_types', 'unit'));
        } catch (\Throwable $throwable) {
            flash('Erro ao carregar tela de cadastro!')->error();
            return redirect()->back();
        }
    }

    public function store(ManagementReportRequest $request)
    {
        if (! Gate::allows('Criar Relatório de Gestão')) {
            abort(403);
        }

        try {
            DB::beginTransaction();

            $report = $this->managementReportCreateService->create($request->toArray());

            DB::commit();

            flash('Relatório de Gestão criado com sucesso, adicione arquivos ao seu relatório')->success();
            return redirect()->route('relatorio_de_gestao.show', $report->id);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($management_report_id)
    {
        if (! Gate::allows('Ver e Listar Relatório de Gestão')) {
            abort(403);
        }

        try {
            $unit = Unit::where('web', true)->first();
            $management_report = ManagementReport::with(['managementReportType', 'file'])->findOrFail($management_report_id);
            $management_report_types = ManagementReportType::all();

            return Inertia::render('ManagementReport/Show', compact('unit', 'management_report', 'management_report_types'));
        } catch (\Exception $exception) {
            flash('Erro ao buscar Relatório de Gestão!')->error();
            return redirect()->back();
        }
    }

    public function update(ManagementReportRequest $request, $management_report_id)
    {
        if (! Gate::allows('Editar Relatório de Gestão')) {
            abort(403);
        }

        try {
            DB::beginTransaction();

            $request->validate([
                'initial_date' => 'required'
            ]);

            $currentuuid = Auth::user()->id;
            $managementReportData = array_merge(
                $request->toArray(),
                [
                    'user_id' => $currentuuid
                ]
            );

            $this->managementReportUpdateService->update($managementReportData, $management_report_id);

            DB::commit();
            flash('Relatório de Gestão editado com sucesso!')->success();
            
            return redirect()->route('relatorio_de_gestao.show', $management_report_id);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            flash('Erro ao editar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($management_report_id)
    {
        if (! Gate::allows('Deletar Relatório de Gestão')) {
            abort(403);
        }

        try {
            $for_delete = ManagementReport::findOrFail($management_report_id);
            $for_delete->delete();

            flash('Relatório de Gestão deletado com sucesso!')->success();
            return redirect()->route('relatorio_de_gestao.index');
        } catch (\Exception $exception) {
            flash('Erro ao deletar o Relatório de Gestão!')->error();
            return redirect()->back();
        }
    }

    public function web_index()
    {
        $unit = Unit::where('web', true)->first();
        $management_reports = ManagementReport::with(['managementReportType', 'file'])->get();
        
        return view('web.management_report.index', compact('unit', 'management_reports'));
    }
}
