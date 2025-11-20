<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFooterLogoRequest;
use App\Http\Requests\StoreFooterLogoRequest;
use App\Http\Requests\UpdateFooterLogoRequest;
use App\Models\FooterLogo;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class FooterLogoController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('footer_logo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $footerLogos = FooterLogo::with(['media'])->get();

        return view('admin.footerLogos.index', compact('footerLogos'));
    }

    public function create()
    {
        abort_if(Gate::denies('footer_logo_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.footerLogos.create');
    }

    public function store(StoreFooterLogoRequest $request)
    {
        $footerLogo = FooterLogo::create($request->all());

        if ($request->input('upload_image', false)) {
            $footerLogo->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_image'))))->toMediaCollection('upload_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $footerLogo->id]);
        }

        return redirect()->route('admin.footer-logos.index');
    }

    public function edit(FooterLogo $footerLogo)
    {
        abort_if(Gate::denies('footer_logo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.footerLogos.edit', compact('footerLogo'));
    }

    public function update(UpdateFooterLogoRequest $request, FooterLogo $footerLogo)
    {
        $footerLogo->update($request->all());

        if ($request->input('upload_image', false)) {
            if (! $footerLogo->upload_image || $request->input('upload_image') !== $footerLogo->upload_image->file_name) {
                if ($footerLogo->upload_image) {
                    $footerLogo->upload_image->delete();
                }
                $footerLogo->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_image'))))->toMediaCollection('upload_image');
            }
        } elseif ($footerLogo->upload_image) {
            $footerLogo->upload_image->delete();
        }

        return redirect()->route('admin.footer-logos.index');
    }

    public function show(FooterLogo $footerLogo)
    {
        abort_if(Gate::denies('footer_logo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.footerLogos.show', compact('footerLogo'));
    }

    public function destroy(FooterLogo $footerLogo)
    {
        abort_if(Gate::denies('footer_logo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $footerLogo->delete();

        return back();
    }

    public function massDestroy(MassDestroyFooterLogoRequest $request)
    {
        $footerLogos = FooterLogo::find(request('ids'));

        foreach ($footerLogos as $footerLogo) {
            $footerLogo->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('footer_logo_create') && Gate::denies('footer_logo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new FooterLogo();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
