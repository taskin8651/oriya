<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEpaperRequest;
use App\Http\Requests\StoreEpaperRequest;
use App\Http\Requests\UpdateEpaperRequest;
use App\Models\Epaper;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class EpaperController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('epaper_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $epapers = Epaper::with(['media'])->get();

        return view('admin.epapers.index', compact('epapers'));
    }

    public function create()
    {
        abort_if(Gate::denies('epaper_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.epapers.create');
    }

    public function store(StoreEpaperRequest $request)
    {
        $epaper = Epaper::create($request->all());

        if ($request->input('pdf_file', false)) {
            $epaper->addMedia(storage_path('tmp/uploads/' . basename($request->input('pdf_file'))))->toMediaCollection('pdf_file');
        }

        if ($request->input('cover_image', false)) {
            $epaper->addMedia(storage_path('tmp/uploads/' . basename($request->input('cover_image'))))->toMediaCollection('cover_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $epaper->id]);
        }

        return redirect()->route('admin.epapers.index');
    }

    public function edit(Epaper $epaper)
    {
        abort_if(Gate::denies('epaper_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.epapers.edit', compact('epaper'));
    }

    public function update(UpdateEpaperRequest $request, Epaper $epaper)
    {
        $epaper->update($request->all());

        if ($request->input('pdf_file', false)) {
            if (! $epaper->pdf_file || $request->input('pdf_file') !== $epaper->pdf_file->file_name) {
                if ($epaper->pdf_file) {
                    $epaper->pdf_file->delete();
                }
                $epaper->addMedia(storage_path('tmp/uploads/' . basename($request->input('pdf_file'))))->toMediaCollection('pdf_file');
            }
        } elseif ($epaper->pdf_file) {
            $epaper->pdf_file->delete();
        }

        if ($request->input('cover_image', false)) {
            if (! $epaper->cover_image || $request->input('cover_image') !== $epaper->cover_image->file_name) {
                if ($epaper->cover_image) {
                    $epaper->cover_image->delete();
                }
                $epaper->addMedia(storage_path('tmp/uploads/' . basename($request->input('cover_image'))))->toMediaCollection('cover_image');
            }
        } elseif ($epaper->cover_image) {
            $epaper->cover_image->delete();
        }

        return redirect()->route('admin.epapers.index');
    }

    public function show(Epaper $epaper)
    {
        abort_if(Gate::denies('epaper_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.epapers.show', compact('epaper'));
    }

    public function destroy(Epaper $epaper)
    {
        abort_if(Gate::denies('epaper_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $epaper->delete();

        return back();
    }

    public function massDestroy(MassDestroyEpaperRequest $request)
    {
        $epapers = Epaper::find(request('ids'));

        foreach ($epapers as $epaper) {
            $epaper->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('epaper_create') && Gate::denies('epaper_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Epaper();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
