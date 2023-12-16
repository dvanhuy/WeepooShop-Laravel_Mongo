<?php

namespace App\Http\Requests\Bill;

use Illuminate\Foundation\Http\FormRequest;

class CheckOutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "cartIDs"=>["required"],
            "totalmoney"=>["required"],
            "payments"=>["required"],
            "sodienthoai"=>["required"],
            "diachi"=>["required"],
        ];
    }

    public function messages()
    {
        return [
            'sodienthoai.required'=> 'Bắt buộc nhập',
            'diachi.required'=> 'Bắt buộc nhập',
        ] ;
    }
}
