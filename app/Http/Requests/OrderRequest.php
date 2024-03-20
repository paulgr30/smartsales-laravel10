<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            /*'user_id' => [
                'required',
                'exists:users,id',
            ],
            'order_status_id' => [
                'required',
                'exists:order_statuses,id',
            ],
            'number' => [
                'required',
                'unique:orders,number,' . $id . ',id',
            ],*/




            'items' => [
                'required',
                'array',
                'distinct'
            ],
            'items.*.product_id' => [
                'required',
                'exists:products,id',
            ],
            'items.*.quantity' => [
                'required',
                'numeric',
                'min:1'
            ],
        ];
    }

    public function attributes()
    {
        return [
            'customer_id'       => 'cliente',
            'user_id'           => 'usuario',
            'order_statuys_id'  => 'estado',
            'number'            => 'numero orden',

            'items'             => 'productos',
            'items.*.product_id'        => 'producto',
            'items.*.quantity'  => 'cantidad',
        ];
    }
}
