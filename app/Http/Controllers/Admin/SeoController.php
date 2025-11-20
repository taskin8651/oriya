<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySeoRequest;
use App\Http\Requests\StoreSeoRequest;
use App\Http\Requests\UpdateSeoRequest;
use App\Models\Seo;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class SeoController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('seo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seos = Seo::with(['media'])->get();

        return view('admin.seos.index', compact('seos'));
    }

    public function create()
    {
        abort_if(Gate::denies('seo_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.seos.create');
    }

    public function store(StoreSeoRequest $request)
    {
        $seo = Seo::create($request->all());

        if ($request->input('social_share_image', false)) {
            $seo->addMedia(storage_path('tmp/uploads/' . basename($request->input('social_share_image'))))->toMediaCollection('social_share_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $seo->id]);
        }

        return redirect()->route('admin.seos.index');
    }

    public function edit(Seo $seo)
    {
        abort_if(Gate::denies('seo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.seos.edit', compact('seo'));
    }

    public function update(UpdateSeoRequest $request, Seo $seo)
    {
        $seo->update($request->all());

        if ($request->input('social_share_image', false)) {
            if (! $seo->social_share_image || $request->input('social_share_image') !== $seo->social_share_image->file_name) {
                if ($seo->social_share_image) {
                    $seo->social_share_image->delete();
                }
                $seo->addMedia(storage_path('tmp/uploads/' . basename($request->input('social_share_image'))))->toMediaCollection('social_share_image');
            }
        } elseif ($seo->social_share_image) {
            $seo->social_share_image->delete();
        }

        return redirect()->route('admin.seos.index');
    }

    public function show(Seo $seo)
    {
        abort_if(Gate::denies('seo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.seos.show', compact('seo'));
    }

    public function destroy(Seo $seo)
    {
        abort_if(Gate::denies('seo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seo->delete();

        return back();
    }

    public function massDestroy(MassDestroySeoRequest $request)
    {
        $seos = Seo::find(request('ids'));

        foreach ($seos as $seo) {
            $seo->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('seo_create') && Gate::denies('seo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Seo();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
