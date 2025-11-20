<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBreakingNewsRequest;
use App\Http\Requests\StoreBreakingNewsRequest;
use App\Http\Requests\UpdateBreakingNewsRequest;
use App\Models\BreakingNews;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BreakingNewsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('breaking_news_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $breakingNewss = BreakingNews::all();

        return view('admin.breakingNewss.index', compact('breakingNewss'));
    }

    public function create()
    {
        abort_if(Gate::denies('breaking_news_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.breakingNewss.create');
    }

    public function store(StoreBreakingNewsRequest $request)
    {
        $breakingNews = BreakingNews::create($request->all());

        return redirect()->route('admin.breaking-newss.index');
    }

    public function edit(BreakingNews $breakingNews)
    {
        abort_if(Gate::denies('breaking_news_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.breakingNewss.edit', compact('breakingNews'));
    }

    public function update(UpdateBreakingNewsRequest $request, BreakingNews $breakingNews)
    {
        $breakingNews->update($request->all());

        return redirect()->route('admin.breaking-newss.index');
    }

    public function show(BreakingNews $breakingNews)
    {
        abort_if(Gate::denies('breaking_news_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.breakingNewss.show', compact('breakingNews'));
    }

    public function destroy(BreakingNews $breakingNews)
    {
        abort_if(Gate::denies('breaking_news_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $breakingNews->delete();

        return back();
    }

    public function massDestroy(MassDestroyBreakingNewsRequest $request)
    {
        $breakingNewss = BreakingNews::find(request('ids'));

        foreach ($breakingNewss as $breakingNews) {
            $breakingNews->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
