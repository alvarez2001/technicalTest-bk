<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSaleRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'quantity' => 'required|min:1',
        ];
    }

}
