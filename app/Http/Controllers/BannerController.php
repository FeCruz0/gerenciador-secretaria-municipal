<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BannerType;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Services\BannerService;
use App\Services\BannerCreateService;
use App\Services\BannerUpdateService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class BannerController extends Controller
{
    
    public function __construct(
        protected BannerService $bannerService,
        protected BannerCreateService $bannerCreateService,
        protected BannerUpdateService $bannerUpdateService,
    ){}

    public function index()
    {
        if (! Gate::allows('Ver e Listar Banners')) {
            abort(403);
        }

        try {
            $unit = Unit::where('web', true)->first();
            $types = BannerType::with('banner')->orderBy('title', 'asc')->get();
            return Inertia::render('Banner/Index', compact('types', 'unit'));
        } catch (\Throwable $throwable) {
            return redirect()->back()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao procurar os Banners Cadastrados!',
            ]);
        }
    }

    public function update(
        Request $request, $type_id
    ){
        if (! Gate::allows('Editar Banner')) {
            abort(403);
        }
        try {
            DB::beginTransaction();
                
            $request->validate([
                'title' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
            ]);
        
            $path = Storage::disk('banners')->put('image', $request->file('image'));

            $bannerData = array_merge(
                $request->toArray(),
                [
                    'path'  => $path
                ]
            );

            $this->bannerUpdateService->update($bannerData, $type_id);
            
            DB::commit();
            return redirect()->back()->with('flash', [
                'type'    => 'success',
                'message' => 'Banner editado com sucesso!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            DB::rollBack();
            throw $exception;
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash', [
                'type'    => 'error',
                'message' => 'Erro ao editar!',
            ]);
        }
    }
}
