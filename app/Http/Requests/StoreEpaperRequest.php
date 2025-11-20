<?php

namespace App\Http\Requests;

use App\Models\Epaper;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEpaperRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('epaper_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'nullable',
            ],
            'publication_date' => [
                'string',
                'nullable',
            ],
            'edition' => [
                'string',
                'nullable',
            ],
        ];
    }
}
