<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ManagementReportTypeService;
use App\Services\ManagementReportTypeCreateService;
use App\Services\ManagementReportTypeUpdateService;
use App\Http\Requests\ManagementReportTypeRequest;
use App\Models\ManagementReportType;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Models\Unit;

class ManagementReportTypeController extends Controller
{
    //
    public function __construct(
        protected ManagementReportTypeService $managementReportTypeService,
        protected ManagementReportTypeCreateService $managementReportTypeCreateService,
        protected ManagementReportTypeUpdateService $managementReportTypeUpdateService,
    ){}

    public function index(): View
    {
        if (! Gate::allows('Ver e Listar Abrangencia')) {
            return view('pages.not-authorized');
        }

        try{
            $pageConfigs = ['pageHeader' => false];

            $unit = Unit::where('web', true)->first();
            $management_report_types = ManagementReportType::all();
            return view('admin.management_report.type_index', ['pageConfigs' => $pageConfigs], compact('unit', 'management_report_types'));
        } catch (\Throwable $throwable) {
            dd($throwable);
            flash('Erro ao procurar as Coverages Cadastradas!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function store(
        ManagementReportTypeRequest $request
    ){
        if (! Gate::allows('Criar Abrangencia')) {
            return view('pages.not-authorized');
        }
        try {
            DB::beginTransaction();

            $this->managementReportTypeCreateService->create($request->toArray());

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

}
