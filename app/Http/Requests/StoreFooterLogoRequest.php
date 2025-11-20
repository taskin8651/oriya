<?php

namespace App\Http\Requests;

use App\Models\FooterLogo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFooterLogoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('footer_logo_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'nullable',
            ],
        ];
    }
}
