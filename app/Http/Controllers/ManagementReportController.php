<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\ManagementReport;
use App\Models\ManagementReportType;
use App\Http\Requests\ManagementReportRequest;
use App\Services\ManagementReportService;
use App\Services\ManagementReportCreateService;
use App\Services\ManagementReportUpdateService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ManagementReportController extends Controller
{
    //

    public function __construct(
        protected ManagementReportService $managementReportService,
        protected ManagementReportCreateService $managementReportCreateService,
        protected ManagementReportUpdateService $managementReportUpdateService,
    ){
    }

    public function index(): View
    {

        if (! Gate::allows('Ver e Listar Relatório de Gestão')) {
            return view('pages.not-authorized');
        }

        try{
            $pageConfigs = ['pageHeader' => false];
            $unit = Unit::where('web', true)->first();


            $management_reports = ManagementReport::all();

            return view('admin.management_report.index', ['pageConfigs' => $pageConfigs], compact('management_reports', 'unit'));
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar os Relatórios de Gestão Cadastrados!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function create(): View
    {
        if (! Gate::allows('Criar Relatório de Gestão')) {
            return view('pages.not-authorized');
        }

        $pageConfigs = ['pageHeader' => false];
        $unit = Unit::where('web', true)->first();

        $management_reports = ManagementReport::all();
        $management_report_types = ManagementReportType::all();


        return view('admin.management_report.create', ['pageConfigs' => $pageConfigs], compact('management_reports','management_report_types', 'unit'));

    }

    public function store(
        ManagementReportRequest $request
    ){
        if (! Gate::allows('Criar Relatório de Gestão')) {
            return view('pages.not-authorized');
        }
        try {
            DB::beginTransaction();

            $currentuuid = Auth::user()->id;

            $this->managementReportCreateService->create($request->toArray());

            flash('Relatório de Gestão criado com sucesso, adicione arquivos ao seu relatório')->success();
            DB::commit();

            $unit = Unit::where('web', true)->first();

            $management_report = ManagementReport::find($request['management_report_type_id']);
            $management_report_types = ManagementReportType::all();

            return view('admin.management_report.show', compact('unit', 'management_report', 'management_report_types' ));
        }catch (\Throwable $throwable){
            dd($throwable);
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            //return redirect()->back()->withInput();
        }
    }

    public function show($management_report_id)
    {

        if (! Gate::allows('Ver e Listar Relatório de Gestão')) {
            return view('pages.not-authorized');
        }

        try{
            // $project = $this->projectService->show($project_id);

            $unit = Unit::where('web', true)->first();

            $management_report = ManagementReport::find($management_report_id);
            $management_report_types = ManagementReportType::all();

            return view('admin.management_report.show', compact('unit', 'management_report', 'management_report_types' ));
        } catch (\Exception $exception) {
            flash('Erro ao buscar Relatório de Gestão!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function update(
        ManagementReportRequest $request, $management_report_id
    ){
        if (! Gate::allows('Editar Relatório de Gestão')) {
            return view('pages.not-authorized');
        }
        try {
            DB::beginTransaction();

            $currentuuid = Auth::user()->id;

            $request->validate([
                'initial_date' => 'required'
            ]);

            $managementReportData = array_merge(
                $request->toArray(),
                [
                    'user_id'  => $currentuuid
                ]
            );
            $this->managementReportUpdateService->update($managementReportData, $management_report_id);

            flash('Relatório de Gestão editado com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($management_report_id)
    {

        if (! Gate::allows('Deletar Relatório de Gestão')) {
            return view('pages.not-authorized');
        }

        try{
            $for_delete = ManagementReport::find($management_report_id);
            $for_delete->delete();
            flash('Projeto deletado com sucesso!')->success();
            return redirect('/projetos');
        } catch (\Exception $exception) {
            flash('Erro ao deletar a Projeto!')->error();
            return redirect()->back()->withInput();
        }
    }
    //web


    public function web_index()
    {
        $unit = Unit::where('web', true)->first();
        $management_reports = ManagementReport::all();
        return view('web.management_report.index', compact('unit', 'management_reports'));
    }
}
