<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBreakingNewsRequest;
use App\Http\Requests\UpdateBreakingNewsRequest;
use App\Http\Resources\Admin\BreakingNewsResource;
use App\Models\BreakingNews;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BreakingNewsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('breaking_news_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BreakingNewsResource(BreakingNews::all());
    }

    public function store(StoreBreakingNewsRequest $request)
    {
        $breakingNews = BreakingNews::create($request->all());

        return (new BreakingNewsResource($breakingNews))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BreakingNews $breakingNews)
    {
        abort_if(Gate::denies('breaking_news_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BreakingNewsResource($breakingNews);
    }

    public function update(UpdateBreakingNewsRequest $request, BreakingNews $breakingNews)
    {
        $breakingNews->update($request->all());

        return (new BreakingNewsResource($breakingNews))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BreakingNews $breakingNews)
    {
        abort_if(Gate::denies('breaking_news_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $breakingNews->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
