<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyHeaderLogoRequest;
use App\Http\Requests\StoreHeaderLogoRequest;
use App\Http\Requests\UpdateHeaderLogoRequest;
use App\Models\HeaderLogo;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class HeaderLogoController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('header_logo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $headerLogos = HeaderLogo::with(['media'])->get();

        return view('admin.headerLogos.index', compact('headerLogos'));
    }

    public function create()
    {
        abort_if(Gate::denies('header_logo_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.headerLogos.create');
    }

    public function store(StoreHeaderLogoRequest $request)
    {
        $headerLogo = HeaderLogo::create($request->all());

        if ($request->input('upload_image', false)) {
            $headerLogo->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_image'))))->toMediaCollection('upload_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $headerLogo->id]);
        }

        return redirect()->route('admin.header-logos.index');
    }

    public function edit(HeaderLogo $headerLogo)
    {
        abort_if(Gate::denies('header_logo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.headerLogos.edit', compact('headerLogo'));
    }

    public function update(UpdateHeaderLogoRequest $request, HeaderLogo $headerLogo)
    {
        $headerLogo->update($request->all());

        if ($request->input('upload_image', false)) {
            if (! $headerLogo->upload_image || $request->input('upload_image') !== $headerLogo->upload_image->file_name) {
                if ($headerLogo->upload_image) {
                    $headerLogo->upload_image->delete();
                }
                $headerLogo->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_image'))))->toMediaCollection('upload_image');
            }
        } elseif ($headerLogo->upload_image) {
            $headerLogo->upload_image->delete();
        }

        return redirect()->route('admin.header-logos.index');
    }

    public function show(HeaderLogo $headerLogo)
    {
        abort_if(Gate::denies('header_logo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.headerLogos.show', compact('headerLogo'));
    }

    public function destroy(HeaderLogo $headerLogo)
    {
        abort_if(Gate::denies('header_logo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $headerLogo->delete();

        return back();
    }

    public function massDestroy(MassDestroyHeaderLogoRequest $request)
    {
        $headerLogos = HeaderLogo::find(request('ids'));

        foreach ($headerLogos as $headerLogo) {
            $headerLogo->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('header_logo_create') && Gate::denies('header_logo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new HeaderLogo();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
