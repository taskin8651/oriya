<?php

namespace App\Http\Requests;

use App\Models\FooterLogo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFooterLogoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('footer_logo_edit');
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
