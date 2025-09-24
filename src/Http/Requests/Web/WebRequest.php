<?php

namespace ErfanMasboogh\Laran\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest as BaseRequest;

class WebRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
