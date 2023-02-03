<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class StoreSaleRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                Rule::exists('products', 'id')
                    ->where('id', $this->request->get('product_id')),
            ],
            'quantity' => 'required|min:1',
        ];
    }

}
