<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConservationUnitRequest;
use App\Models\Unit;
use App\Models\ConservationUnit;
use App\Models\Coverage;
use App\Models\ConservationUnitType;
use App\Models\Gallery;
use App\Models\Leadership;
use App\Models\News;
use App\Models\Post;
use App\Models\Project;
use App\Services\ConservationUnitService;
use App\Services\ConservationUnitCreateService;
use App\Services\ConservationUnitUpdateService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ConservationUnitController extends Controller
{
    public function __construct(
        protected ConservationUnitService $conservationUnitService,
        protected ConservationUnitCreateService $conservationUnitCreateService,
        protected ConservationUnitUpdateService $conservationUnitUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Ver e Listar Unidade de Conservacao')) {
            abort(403);
        }

        $conservation_units = ConservationUnit::with('type')->get();

        return Inertia::render('ConservationUnit/Index', [
            'conservation_units' => $conservation_units,
        ]);
    }

    public function create()
    {
        if (! Gate::allows('Criar Unidade de Conservacao')) {
            abort(403);
        }

        $coverages = Coverage::all();
        $types = ConservationUnitType::all();

        return Inertia::render('ConservationUnit/Create', [
            'coverages' => $coverages,
            'types' => $types,
        ]);
    }

    public function store(
        ConservationUnitRequest $request
    ){
        if (! Gate::allows('Criar Unidade de Conservacao')) {
            abort(403);
        }
        try {
            DB::beginTransaction();

            if(isset($request['thumb'])){
                $request->validate([
                    'title' => 'required',
                    'thumb' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

                $path = Storage::disk('conservation_units')->put('thumbs', $request->file('thumb'));

                $conservationUnitData = array_merge(
                    $request->toArray(),
                    [
                        'thumb'  => $path,
                    ]
                );
            }
            else{
                $request->validate([
                    'title' => 'required'
                ]);

                $conservationUnitData = array_merge(
                    $request->toArray(),
                    [
                        'user_id'  => '1',
                    ]
                );
            }

            $this->conservationUnitCreateService->create($conservationUnitData);

            DB::commit();
            return redirect()->route('unid_conservacao.index')->with('flash', [
                'type'    => 'success',
                'message' => 'Unidade de Conservação criada com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao cadastrar Unidade de Conservação!',
            ]);
        }
    }

    public function show($conservation_unit_id)
    {
        if (! Gate::allows('Ver e Listar Unidade de Conservacao')) {
            abort(403);
        }

        try{
            $conservation_unit = ConservationUnit::with('coverages')->findOrFail($conservation_unit_id);
            $coverages = Coverage::all();
            $types = ConservationUnitType::all();

            return Inertia::render('ConservationUnit/Show', [
                'conservation_unit' => $conservation_unit,
                'coverages' => $coverages,
                'types' => $types,
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao buscar a Unidade!',
            ]);
        }
    }

    public function update(
        ConservationUnitRequest $request, $conservation_unit_id
    ){
        if (! Gate::allows('Editar Unidade de Conservacao')) {
            abort(403);
        }
        try {
            DB::beginTransaction();
            if(isset($request['thumb'])){
                $request->validate([
                    'title' => 'required',
                    'thumb' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

                $path = Storage::disk('conservation_units')->put('thumbs', $request->file('thumb'));

                $data = array_merge(
                    [
                        'objective' => null,
                        'thumb_description' => null,
                    ],
                    $request->toArray(),
                    [
                        'thumb'  => $path
                    ]
                );
            }
            else{
                $request->validate([
                    'title' => 'required'
                ]);

                $data = array_merge(
                    [
                        'objective' => null,
                        'thumb_description' => null,
                    ],
                    $request->toArray(),
                    [
                        'user_id'  => '1'
                    ]
                );
            }
            $this->conservationUnitUpdateService->update($data, $conservation_unit_id);

            DB::commit();
            return redirect()->route('unid_conservacao.index')->with('flash', [
                'type'    => 'success',
                'message' => 'Unidade de Conservação editada com sucesso!',
            ]);
        }catch (\Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao editar Unidade de Conservação!',
            ]);
        }
    }

    public function destroy($conservationUnit)
    {
        if (! Gate::allows('Deletar Unidade de Conservacao')) {
            abort(403);
        }

        try{
            $conservationUnitModel = ConservationUnit::findOrFail($conservationUnit);
            $conservationUnitModel->delete();
            return redirect()->route('unid_conservacao.index')->with('flash', [
                'type'    => 'success',
                'message' => 'Unidade de Conservação excluída com sucesso!',
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao deletar Unidade de Conservação!',
            ]);
        }
    }

    public function web_index()
    {
        try{
            $posts = Post::where('type_post_id', 1)->paginate(5)->load(['media']);
            $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
            $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
            $leaderships = Leadership::all();
            $galleries = Gallery::all();
            $unit = Unit::where('web', true)->first();
            $conservation_units = ConservationUnit::with('type')->where('status', 'PUBLISHED')->orderBy('id', 'desc')->get();

            $types = ConservationUnitType::orderBy('type', 'asc')->get();

            return view('web.unidade_de_conservacao.index', compact('posts', 'news', 'unit', 'projects', 'leaderships', 'galleries', 'conservation_units', 'types'));

        } catch (\Exception $exception) {
            flash('Erro ao carregar a página!')->error();
            return redirect()->back();
        }
    }

    public function web_show($conservation_unit_id)
    {
        $posts = Post::where('type_post_id', 1)->paginate(5)->load(['media']);
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        $unit = Unit::where('web', true)->first();
        $conservation_unit = ConservationUnit::find($conservation_unit_id);
        $conservation_units = ConservationUnit::where('status', 'PUBLISHED')->orderBy('id', 'desc')->get();
        return view('web.unidade_de_conservacao.show', compact('posts', 'news', 'unit', 'projects', 'leaderships', 'galleries', 'conservation_units', 'conservation_unit'));
    }
}
