<?php

namespace App\Http\Requests;

use App\Models\BreakingNews;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBreakingNewsRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('breaking_news_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:breaking_newss,id',
        ];
    }
}
