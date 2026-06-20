<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bidding;
use App\Models\BiddingAgreement;
use App\Models\BiddingFile;
use App\Models\BiddingWinner;
use App\Http\Requests\BiddingCreateRequest;
use App\Models\Banner;
use App\Models\BiddingModality;
use App\Models\BiddingSituation;
use App\Models\Gallery;
use App\Models\Leadership;
use App\Models\News;
use App\Models\People;
use App\Models\Project;
use App\Models\TypeRequest;
use App\Models\Unit;
use App\Services\BiddingService;
use App\Services\BiddingCreateService;
use App\Services\BiddingUpdateService;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Enums\Permission;

class BiddingController extends Controller
{
    
    public function __construct(
        protected BiddingService $biddingService,
        protected BiddingCreateService $biddingCreateService,
        protected BiddingUpdateService $biddingUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows(Permission::VIEW_BIDDINGS->value)) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();

            $biddings = Bidding::with('modality')->latest()->get();
            return Inertia::render('Bidding/Index', [
                'biddings' => $biddings,
                'unit' => $unit,
            ]);
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as Assuntos Cadastrados!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function create()
    {
        if (! Gate::allows(Permission::CREATE_BIDDINGS->value)) {
            abort(403, 'This action is unauthorized.');
        }

        $unit = Unit::where('web', true)->first();

        $modalities = BiddingModality::with('biddings')->orderBy('title', 'asc')->get();
        $situations = BiddingSituation::with('biddings')->orderBy('title', 'asc')->get();

        return Inertia::render('Bidding/Create', [
            'modalities' => $modalities,
            'situations' => $situations,
            'unit' => $unit,
        ]);
    }

    public function store(
        BiddingCreateRequest $request
    ){
        if (! Gate::allows(Permission::EDIT_BIDDINGS->value)) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();
            $fileData = array_merge(
                $request->toArray(),
                [
                    'login'  => 0
                ]
            );
            $this->biddingCreateService->create($fileData);
            
            flash('Licitação criada com sucesso!')->success();
            DB::commit();
            return redirect()->route('licitacoes.index');
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($bidding_id)
    {
        if (! Gate::allows(Permission::VIEW_BIDDINGS->value)) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();
            $bidding = Bidding::find($bidding_id);
            $biddings = Bidding::with('modality')->latest()->get();
            $possible_winners = People::whereDoesntHave('departaments')->orderBy('full_name', 'asc')->get();
            $modalities = BiddingModality::with('biddings')->orderBy('title', 'asc')->get();
            $situations = BiddingSituation::with('biddings')->orderBy('title', 'asc')->get();

            return Inertia::render('Bidding/Show', [
                'bidding' => $bidding,
                'biddings' => $biddings,
                'modalities' => $modalities,
                'situations' => $situations,
                'possible_winners' => $possible_winners,
                'unit' => $unit,
            ]);
        } catch (\Exception $exception) {
            flash('Erro ao buscar o Tipo de Acesso!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function update(
        BiddingCreateRequest $request, $bidding_id
    ){
        if (! Gate::allows(Permission::EDIT_BIDDINGS->value)) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();
            $this->biddingUpdateService->update($request->toarray(), $bidding_id);
            
            flash('Licitação editada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($bidding_id)
    {
        if (! Gate::allows(Permission::DELETE_BIDDINGS->value)) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $bidding = Bidding::find($bidding_id);
            $bidding->delete();
            flash('Licitação deletada com sucesso!')->success();
            return redirect('/legislacoes');
        } catch (\Exception $exception) {
            dd($exception);
            flash('Erro ao deletar a Licitação!')->error();
            return redirect()->back()->withInput();
        }
    }

    //site
    

    public function index_web(): View
    {
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 8)->first();
        $type_requests = TypeRequest::all();
        $biddings = Bidding::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(10);
        $modalities = BiddingModality::all();
        $situations = BiddingSituation::all();
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        return view('web.bidding.index', compact('banner', 'biddings', 'modalities', 'situations', 'unit', 'type_requests', 'news', 'projects', 'leaderships', 'galleries'));
    }

    public function web_index_filter(Request $request)
    {
        $unit = Unit::where('web', true)->first();
        $banner = Banner::where('banner_type_id', 8)->first();
        $type_requests = TypeRequest::all();
        $modalities = BiddingModality::all();
        $situations = BiddingSituation::all();
        $biddings = Bidding::filter($request->all())->where('status', 'PUBLISHED')->paginate(5);
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        return view('web.bidding.index', compact('banner', 'biddings', 'modalities', 'situations', 'unit', 'type_requests', 'news', 'projects', 'leaderships', 'galleries'));
    }

    public function show_web($bidding_id)
    {
        try{
            $unit = Unit::where('web', true)->first();
            $type_requests = TypeRequest::all();
            $bidding = $this->biddingService->show($bidding_id);
            $bidding_files = BiddingFile::where('bidding_id', $bidding->id)->paginate(10);
            $bidding_winners = BiddingWinner::where('bidding_id', $bidding_id)->paginate(10);
            $bidding_agreements = BiddingAgreement::where('bidding_id', $bidding_id)->paginate(10);
            $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
            $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
            $leaderships = Leadership::all();
            $galleries = Gallery::all();
            return view('web.bidding.show', compact('bidding', 'bidding_files', 'bidding_winners', 'bidding_agreements', 'unit', 'type_requests', 'news', 'projects', 'leaderships', 'galleries'));
        } catch (\Throwable $throwable) {
            flash('Erro ao buscar registro!')->error();
            return redirect()->back()->withInput();
        }
    }

}
