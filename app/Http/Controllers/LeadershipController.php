<?php

namespace App\Http\Controllers;

use App\Models\Leadership;
use App\Http\Requests\LeadershipRequest;
use App\Models\Banner;
use App\Models\Gallery;
use App\Models\LeadershipCategory;
use App\Models\LeadershipSocialMedia;
use App\Models\News;
use App\Models\Project;
use App\Models\SocialMedia;
use App\Models\Unit;
use App\Services\LeadershipService;
use App\Services\LeadershipCreateService;
use App\Services\LeadershipUpdateService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Throwable;

use Inertia\Inertia;

class LeadershipController extends Controller
{
    public function __construct(
        protected LeadershipService $leadershipService,
        protected LeadershipCreateService $leadershipCreateService,
        protected LeadershipUpdateService $leadershipUpdateService,
    ){}

    public function index()
    {
        
        if (! Gate::allows('Ver e Listar Liderança')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $unit = Unit::where('web', true)->first();
            $leaderships = Leadership::with('socialMedia')
                                        ->latest()
                                        ->get();
            return Inertia::render('Leadership/Index', [
                'leaderships' => $leaderships,
                'unit' => $unit
            ]);
        } catch (\Throwable $throwable) {
            flash('Erro ao procurar as lideranças Cadastradas!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function store(
        LeadershipRequest $request
    ){
        
        if (! Gate::allows('Criar Liderança')) {
            abort(403, 'This action is unauthorized.');
        }

        try {
            DB::beginTransaction();
                 
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);
        
            $path_photo = Storage::disk('leadership')->put('photos', $request->file( key:'photo'));

            $leadershipData = array_merge(
                $request->toArray(),
                [
                    'photo'  => $path_photo
                ]
            );

            $this->leadershipCreateService->create($leadershipData);
            
            flash('Liderança criada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro Cadastrar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function show($leadership_id)
    {
        
        if (! Gate::allows('Ver e Listar Liderança')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $leadership = $this->leadershipService->show($leadership_id);
            $leadership->load('socialMedia');
            $social_media = SocialMedia::all();
            $unit = Unit::where('web', true)->first();

            return Inertia::render('Leadership/Show', [
                'leadership' => $leadership,
                'social_media' => $social_media,
                'unit' => $unit
            ]);
        } catch (\Exception $exception) {
            flash('Erro ao buscar a liderança!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function update(
        LeadershipRequest $request, $leadership_id
    ){
         
        if (! Gate::allows('Editar Liderança')) {
            abort(403, 'This action is unauthorized.');
        }
        try {
            DB::beginTransaction();

            if(isset($request['photo'])){
                $request->validate([
                    'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);
            
                $path_photo = Storage::disk('leadership')->put('photos', $request->file( key:'photo'));

                $leadershipData = array_merge(
                    $request->toArray(),
                    [
                        'photo'  => $path_photo
                    ]
                );
                $this->leadershipUpdateService->update($leadershipData, $leadership_id);
            }else{

                $this->leadershipUpdateService->update($request->toArray(), $leadership_id);

            }
            
            flash('Liderança editada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function destroy($leadership_id)
    {
        
        if (! Gate::allows('Deletar Liderança')) {
            abort(403, 'This action is unauthorized.');
        }

        try{
            $for_delete = Leadership::find($leadership_id);
            $for_delete->delete();
            flash('Liderança deletada com sucesso!')->success();
            return redirect('/liderancas');
        } catch (\Exception $exception) {
            flash('Erro ao deletar a Liderança!')->error();
            return redirect()->back()->withInput();
        }
    }


    public function leadership_social_media_add(
        Request $request
    ){
        if (! Gate::allows('Editar Liderança')) {
            abort(403, 'This action is unauthorized.');
        }

        try {
            DB::beginTransaction();

            LeadershipSocialMedia::create([
                'leadership_id' => $request->leadership_id,
                'social_media_id' => $request->social_media_id,
                'url' => $request->url,
            ]);

            flash('Liderança editada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar a Liderança!')->error();
            return redirect()->back()->withInput();
        }
    }

    public function leadership_social_media_delete(
        $social_media
    ){
        if (! Gate::allows('Editar Liderança')) {
            abort(403, 'This action is unauthorized.');
        }

        try {
            DB::beginTransaction();
            $media = LeadershipSocialMedia::find($social_media);
            $media->forceDelete();
            flash('Mídia deletada com sucesso!')->success();
            DB::commit();
            return redirect()->back();
        }catch (\Throwable $throwable){
            DB::rollBack();
            flash('Erro ao editar a unidade!')->error();
            return redirect()->back()->withInput();
        }
    }

    //web
    

    public function leadership_web_index()
    {
        $banner = Banner::where('banner_type_id', 11)->first();
        $leaderships_headship = Leadership::where('status', 'PUBLISHED')->where('type', 'HEADSHIP')->orderBy('order', 'desc')->paginate(12);
        $leaderships_employee = Leadership::where('status', 'PUBLISHED')->where('type', 'EMPLOYEE')->orderBy('order', 'desc')->paginate(12);
        $unit = Unit::where('web', true)->first();
        $news = News::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(3);
        $projects = Project::where('status', 'PUBLISHED')->orderBy('id', 'desc')->paginate(6);
        $leaderships = Leadership::all();
        $galleries = Gallery::all();
        return view('web.leadership.index', compact('banner', 'leaderships_headship', 'leaderships_employee', 'unit', 'news', 'projects', 'leaderships', 'galleries'));
    }
}
