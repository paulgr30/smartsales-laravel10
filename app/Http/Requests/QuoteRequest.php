<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = empty($this->id) ? 0 : $this->id;

        return [
            'customer_id' => [
                'required',
                'exists:users,id',
            ],
            'user_id' => [
                'required',
                'exists:users,id',
            ],
            'number' => [
                'required',
                'numeric',
                'unique:quotes,number,' . $id . ',id',
            ],
            'expiration_date' => [
                'required',
                'date',
            ],
            /*'subtotal' => [
                'required',
                'numeric',
            ],
            'igv' => [
                'required',
                'numeric',
            ],*/
            'discount' => [
                'required',
                'numeric',
            ],
            /*'total' => [
                'required',
                'numeric',
            ],*/


            'products'  => [
                'required',
                'array',
                'min:1',     // each string must have min 3 chars
                'distinct:strict'
            ],
            'products.*.product_id' => [
                'required',
                'distinct:strict',
                'exists:products,id',
            ],
            'products.*.quantity' => [
                'required',
                'numeric'
            ],
            'products.*.price' => [
                'required',
                'numeric'
            ],
        ];
    }

    public function attributes()
    {
        return [
            'customer_id'     => 'cliente',
            'expiration_date' => 'fecha expiracion',
            'discount'        => 'descuento',
            'products'        => 'productos',
            'products.*.product_id' => 'producto',
            'products.*.quantity'   => 'cantiad',
            'products.*.price'      => 'precio',
        ];
    }
}
