<?php

namespace App\Http\Requests;

use App\Models\FooterLogo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFooterLogoRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('footer_logo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:footer_logos,id',
        ];
    }
}
