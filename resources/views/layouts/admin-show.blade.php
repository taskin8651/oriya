@php
    $ability = Str::snake($resource);
    $editRoute = Str::beforeLast($listRoute, '.') . '.edit';
    $adminDetail = [
        'title' => filled($recordTitle ?? null) ? $recordTitle : trans("cruds.$resource.title_singular"),
        'breadcrumb' => trans('global.show'),
        'listLabel' => trans("cruds.$resource.title"),
        'listRoute' => $listRoute,
        'listUrl' => Gate::allows($ability . '_access') ? route($listRoute) : null,
        'editUrl' => Route::has($editRoute) && Gate::allows($ability . '_edit') ? route($editRoute, $record) : null,
    ];
@endphp
@extends('layouts.admin')
