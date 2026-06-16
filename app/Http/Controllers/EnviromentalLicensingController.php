<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\EnviromentalLicensing;
use App\Http\Requests\EnviromentalLicensingRequest;
use App\Services\EnviromentalLicensingService;
use App\Services\EnviromentalLicensingCreateService;
use App\Services\EnviromentalLicensingUpdateService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class EnviromentalLicensingController extends Controller
{
    public function __construct(
        protected EnviromentalLicensingService $enviromentalLicensingService,
        protected EnviromentalLicensingCreateService $enviromentalLicensingCreateService,
    ){
    }

    public function index(): View
    {

        if (! Gate::allows('Ver e Listar Relatório de Gestão')) {
            return view('pages.not-authorized');
        }

        try{

            $unit = Unit::where('web', true)->first();

            $enviromental_licensing = EnviromentalLicensing::orderBy('id', 'desc')->first();

            return view('admin.enviromental_licensing.index', compact('unit', 'enviromental_licensing' ));
        } catch (\Exception $exception) {
            dd($exception);
            flash('Erro ao buscar Relatório de Licenciamento Ambiental!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function store(
        EnviromentalLicensingRequest $request
    ){
        if (! Gate::allows('Criar Relatório de Gestão')) {
            return view('pages.not-authorized');
        }
        try {
            DB::beginTransaction();

            $currentuuid = Auth::user()->id;

            $this->enviromentalLicensingCreateService->create($request->toArray());

            DB::commit();
            flash('Relatório de licenciamento ambiental adicionado com sucesso')->success();

            $unit = Unit::where('web', true)->first();

            return view('admin.enviromental_licensing.index', compact('unit'));
        }catch (\Throwable $throwable){
            dd($throwable);
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            //return redirect()->back()->withInput();
        }
    }

    public function web_index()
    {
        return view('web.licenciamento_ambiental.licenciamento_web');
    }
}
