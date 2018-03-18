<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstrumentRequest extends FormRequest
{
    /**
     * Determine if the instrument is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'model'              => 'required|max:255',
            'serial_number'      => 'max:255',
            'barcode'            => 'max:255',
            'condition'          => 'digits_between:0,5',
            'to_be_checked'      => 'boolean',
            'brand'              => 'required_without:brand_id',
            'brand_id'           => 'required_without:brand|exists:brands,id',
            'category'           => 'required_without:category_id',
            'category_id'        => 'required_without:category|exists:categories,id',
            'parent_category_id' => 'exists:categories,id',
            'store_id'           => 'exists:stores,id',
            'comment'            => 'max:65536',
            'picture'            => 'file',
        ];
    }
}
