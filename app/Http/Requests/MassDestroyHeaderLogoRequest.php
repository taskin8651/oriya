<?php

namespace App\Http\Requests;

use App\Models\HeaderLogo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyHeaderLogoRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('header_logo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:header_logos,id',
        ];
    }
}
