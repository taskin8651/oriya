<?php

namespace App\Http\Requests;

use App\Models\ContactDetail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateContactDetailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('contact_detail_edit');
    }

    public function rules()
    {
        return [
            'number' => [
                'string',
                'nullable',
            ],
            'email' => [
                'string',
                'nullable',
            ],
        ];
    }
}
