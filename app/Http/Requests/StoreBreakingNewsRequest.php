<?php

namespace App\Http\Requests;

use App\Models\BreakingNews;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBreakingNewsRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('breaking_news_create');
    }

    public function rules()
    {
        return [];
    }
}
