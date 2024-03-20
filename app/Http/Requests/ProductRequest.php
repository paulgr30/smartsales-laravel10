<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'unit_id' => [
                'required',
                'exists:units,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name,' . $id . ',id',
            ],
            'stock_initial' => [
                'required',
                'numeric',
                'min:1'
            ],
            'stock_min' => [
                'required',
                'numeric',
                'min:1'
            ],
            'barcode' => [
                'nullable',
                'string',
                'max:15',
                'unique:products,barcode,' . $id . ',id',
            ],
            'purchase_price' => [
                'required',
                'numeric',
                'min:0'
            ],
            'sale_price' => [
                'required',
                'numeric',
                'min:1'
            ],
            'wholesale_price' => [
                'required',
                'numeric',
                'min:0'
            ],
            'wholesale_quantity' => [
                'required',
                'numeric',
                'min:0'
            ],
        ];
    }

    public function attributes()
    {
        return [
            'category_id'       => 'categoria',
            'unit_id'           => 'unidad',
            'name'              => 'nombre',
            'stock_initial'     => 'stock inicial',
            'stock_min'         => 'stock minimo',
            'purchase_price'    => 'precio compra',
            'sale_price'        => 'precio venta',
            'wholesale_price'   => 'preciox mayor',
            'wholesale_quantity'=> 'cantidad x mayor',
        ];
    }
}
