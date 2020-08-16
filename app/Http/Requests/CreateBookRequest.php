<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'author_id'=>'required',
            'pages'=>'required|integer',
            'title'=>'required|string',
            'annotation'=>'required',
            'img'=>'max:10000|mimes:img,png'
        ];
    }
}
