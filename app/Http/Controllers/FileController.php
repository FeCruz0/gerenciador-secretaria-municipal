<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Models\Bidding;
use App\Models\BiddingAgreement;
use App\Services\FileService;
use App\Services\FileCreateService;
use App\Services\FileUpdateService;

use App\Models\BiddingAgreementFile;
use App\Models\BiddingFile;
use App\Models\EnviromentalLicensing;
use App\Models\ExpenseFile;
use App\Models\File;
use App\Models\FileProject;
use App\Models\FileManagementReport;
use App\Models\ManagementReport;
use App\Models\Project;
use App\Models\FileLegislation;
use App\Models\FileRevenue;
use App\Models\FileType;
use App\Models\Legislation;
use App\Models\TypeRequest;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Services\BiddingAgreementService;
use App\Services\BiddingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Inertia\Inertia;
use Exception;

class FileController extends Controller
{
    public function __construct(
        protected BiddingAgreementService $biddingAgreementService,
        protected BiddingService $biddingService,
        protected FileService $fileService,
        protected FileCreateService $fileCreateService,
        protected FileUpdateService $fileUpdateService,
    ){}

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request['files']['document'] as $key => $files) {
                if ($request['files']['title'][$key]) {

                    $pathfile = Storage::disk('files')->put('documents', $request['files']['document'][$key]);

                    $file = File::create([
                        'file_type_id' => 1,
                        'title' => $request['files']['title'][$key],
                        'url' => $pathfile
                    ]);

                    //Contrato
                    if($request->type == 'bidding_agreement'){
                        BiddingAgreementFile::create([
                            'bidding_agreement_id' => $request->id,
                            'file_id' => $file->id
                        ]);
                    }

                    //Licitação
                    if($request->type == 'bidding'){
                        BiddingFile::create([
                            'bidding_id' => $request->id,
                            'file_id' => $file->id
                        ]);
                    }

                    //Legislação
                    if($request->type == 'legislation'){
                        FileLegislation::create([
                            'legislation_id' => $request->id,
                            'file_id' => $file->id
                        ]);
                    }

                    //Receitas
                    if($request->type == 'revenue'){
                        FileRevenue::create([
                            'file_id' => $file->id,
                            'revenue_id' => $request->id
                        ]);
                    }

                    //Despesas
                    if($request->type == 'expense'){
                        ExpenseFile::create([
                            'file_id' => $file->id,
                            'expense_id' => $request->id
                        ]);
                    }

                    //Projetos
                    if($request->type == 'project'){
                        FileProject::create([
                            'file_id' => $file->id,
                            'project_id' => $request->id,
                        ]);
                    }

                    //Relatório de Gestão
                    if($request->type == 'management_report'){
                        $mg_report = ManagementReport::find($request->id);
                        $mg_report->file_id = $file->id;
                        $mg_report->save();
                    }

                    //Licenciamento Ambiental
                    if($request->type == 'enviromental_licensing'){
                        EnviromentalLicensing::create([
                            'file_id' => $file->id,
                            'title' => $file->title,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('flash', [
                'type' => 'success',
                'message' => 'Registro criado com sucesso!'
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type' => 'error',
                'message' => 'Aconteceu algum erro!'
            ]);
        }
    }

    public function show($file_id)
    {
        try {
            $file = File::find($file_id);
            return Inertia::render('File/Show', compact('file'));
        } catch (\Throwable $throwable) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao buscar registro!'
            ]);
        }
    }

    public function file_web($file_id)
    {
        try {
            $unit = Unit::where('web', true)->first();
            $type_requests = TypeRequest::all();
            $file = File::find($file_id);
            return view('web.file.show', compact('file', 'unit', 'type_requests'));
        } catch (\Throwable $throwable) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao buscar registro!'
            ]);
        }
    }

    public function update(FileRequest $request, $file_id)
    {
        if (! Gate::allows('file-update')) {
            return abort(403);
        }
        try {
            DB::beginTransaction();
            $fileData = array_merge(
                $request->toArray(),
                [
                    'file_id'  => $file_id
                ]
            );
            $this->fileUpdateService->update($fileData);

            DB::commit();
            return redirect()->back()->with('flash', [
                'type' => 'success',
                'message' => 'Registro editado com sucesso!'
            ]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type' => 'error',
                'message' => 'Aconteceu algum erro!'
            ]);
        }
    }

    public function destroy($file)
    {
        if (! Gate::allows('file-delete')) {
            return abort(403);
        }
        try {
            DB::beginTransaction();
            $file = File::find($file);
            $old_path = storage_path() . '/app/public/files/documents/' . str_replace("documents/", "", $file->url);
            $file->delete();
            if (file_exists($old_path)) {
                unlink($old_path);
            }
            DB::commit();

            $redirect = redirect()->back();

            if (count($file->agreements) > 0) {
                $redirect = redirect()->action(
                    [BiddingAgreementController::class, 'show'], ['licitacao_contrato' => $file->agreements->first()->id]
                );
            } elseif (count($file->biddings) > 0) {
                $redirect = redirect()->action(
                    [BiddingController::class, 'show'], ['licitaco' => $file->biddings->first()->id]
                );
            } elseif (count($file->legislations) > 0) {
                $redirect = redirect()->action(
                    [LegislationController::class, 'show'], ['legislaco' => $file->legislations->first()->id]
                );
            } elseif (count($file->revenues) > 0) {
                $redirect = redirect()->action(
                    [RevenueController::class, 'show'], ['receita' => $file->revenues->first()->id]
                );
            } elseif (count($file->expenses) > 0) {
                $redirect = redirect()->action(
                    [ExpenseController::class, 'show'], ['despesa' => $file->expenses->first()->id]
                );
            }

            return $redirect->with('flash', [
                'type' => 'success',
                'message' => 'Registro deletado com sucesso!'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Aconteceu algum erro!'
            ]);
        }
    }

    public function getRegisters(int $idType): JsonResponse
    {
        if ($idType == 0) {
            $registers = BiddingAgreement::all();
        } elseif ($idType == 1) {
            $registers = Bidding::all();
        } elseif ($idType == 2) {
            $registers = Legislation::all();
        }
        return Response::json($registers);
    }
}
