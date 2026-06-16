<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\FaqRequest;
use App\Models\Departament;
use App\Models\Banner;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Leadership;
use App\Models\News;
use App\Models\Project;
use App\Models\Unit;
use App\Services\FaqService;
use App\Services\FaqCreateService;
use App\Services\FaqUpdateService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class FaqController extends Controller
{
    public function __construct(
        protected FaqService $faqService,
        protected FaqCreateService $faqCreateService,
        protected FaqUpdateService $faqUpdateService,
    ){}

    public function index(): View
    {
        if (! Gate::allows('Ver e Listar FAQs')) {
            return view('pages.not-authorized');
        }

        try{
            $pageConfigs = ['pageHeader' => false];
            $unit = Unit::where('web', true)->first();
            $departaments = Departament::all();
            $faqs = Faq::all();
            return view('admin.faq.index', ['pageConfigs' => $pageConfigs], compact('faqs', 'unit','departaments'));
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as FAQs Cadastradas!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function store(
        FaqRequest $request
    ){
        if (! Gate::allows('Criar FAQs')) {
            return view('pages.not-authorized');
        }
        try {
            DB::beginTransaction();
            $this->faqCreateService->create($request->toArray());

            flash('FAQ criada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao adicionar nova FAQ!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($faq_id): View
    {
        if (! Gate::allows('Ver e Listar FAQs')) {
            return view('pages.not-authorized');
        }

        try{
            $faq = Faq::find($faq_id);
            $faqs = Faq::all();
            $unit = Unit::where('web', true)->first();
            $departaments = Departament::all();
            return view('admin.faq.show', compact('faq', 'faqs', 'unit', 'departaments'));
            
        } catch (\Throwable $throwable) {
            flash('Erro ao buscar registro!')->error();
            return redirect()->back()->withInput();
        }
    }
    
    public function update(
        FaqRequest $request, $faq_id
    ){
        if (! Gate::allows('Editar FAQs')) {
            return view('pages.not-authorized');
        }

        try {
            DB::beginTransaction();
            $this->faqUpdateService->update($request->toArray(), $faq_id);

            flash('FAQ editado com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar o FAQ!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($faq)
    {
        if (! Gate::allows('Deletar FAQs')) {
            return view('pages.not-authorized');
        }

        try{
            $faq = Faq::find($faq);
            $faq->delete();
           
            return redirect('/faqs');
            flash('FAQ deletado com sucesso!')->success();
        } catch (\Exception $exception) {
            flash('Erro ao deletar o FAQ!')->error();
            return redirect()->back()->withInput();
        }
    }
    //web
    


}
