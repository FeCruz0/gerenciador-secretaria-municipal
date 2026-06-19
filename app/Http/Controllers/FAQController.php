<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FaqRequest;
use App\Models\Departament;
use App\Models\Faq;
use App\Models\Unit;
use App\Services\FaqService;
use App\Services\FaqCreateService;
use App\Services\FaqUpdateService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class FaqController extends Controller
{
    public function __construct(
        protected FaqService $faqService,
        protected FaqCreateService $faqCreateService,
        protected FaqUpdateService $faqUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Ver e Listar FAQs')) {
            abort(403);
        }

        try {
            $unit = Unit::where('web', true)->first();
            $departaments = Departament::all();
            $faqs = Faq::with('departament')->get();
            return Inertia::render('Faq/Index', compact('faqs', 'unit', 'departaments'));
        } catch (\Throwable $throwable) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao procurar as FAQs Cadastradas!',
            ]);
        }
    }

    public function store(
        FaqRequest $request
    ){
        if (! Gate::allows('Criar FAQs')) {
            abort(403);
        }
        try {
            DB::beginTransaction();

            $request->validate([
                'question'       => 'required|string',
                'answer'         => 'required|string',
                'departament_id' => 'required|exists:departaments,id',
                'status'         => 'required|in:DRAFT,PENDING,PUBLISHED',
            ]);

            $this->faqCreateService->create($request->toArray());

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'FAQ criada com sucesso!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            DB::rollBack();
            throw $exception;
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao adicionar nova FAQ!',
            ]);
        }
    }

    public function show($faq_id)
    {
        if (! Gate::allows('Ver e Listar FAQs')) {
            abort(403);
        }

        try {
            $faq = Faq::with('departament')->find($faq_id);
            $faqs = Faq::with('departament')->get();
            $unit = Unit::where('web', true)->first();
            $departaments = Departament::all();
            return Inertia::render('Faq/Show', compact('faq', 'faqs', 'unit', 'departaments'));
        } catch (\Throwable $throwable) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao buscar registro!',
            ]);
        }
    }
    
    public function update(
        FaqRequest $request, $faq_id
    ){
        if (! Gate::allows('Editar FAQs')) {
            abort(403);
        }

        try {
            DB::beginTransaction();

            $request->validate([
                'question'       => 'required|string',
                'answer'         => 'required|string',
                'departament_id' => 'required|exists:departaments,id',
                'status'         => 'required|in:DRAFT,PENDING,PUBLISHED',
            ]);

            $this->faqUpdateService->update($request->toArray(), $faq_id);

            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'FAQ editada com sucesso!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            DB::rollBack();
            throw $exception;
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao editar o FAQ!',
            ]);
        }
    }

    public function destroy($faq)
    {
        if (! Gate::allows('Deletar FAQs')) {
            abort(403);
        }

        try {
            $faqObj = Faq::find($faq);
            $faqObj->delete();
           
            return redirect('/faqs')->with('flash', [
                'type'    => 'success',
                'message' => 'FAQ deletada com sucesso!',
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao deletar o FAQ!',
            ]);
        }
    }
}
