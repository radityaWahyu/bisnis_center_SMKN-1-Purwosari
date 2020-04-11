<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'nama' => 'required',
            'email' => 'bail|required|email|unique:users,email',
            'password' => 'required',
            'level' => 'bail|required|in:admin,operator',
            'phone' => 'bail|required|numeric',
            'image' => 'bail|required|mimes:jpeg,bmp,png|max:2000'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Data :attribute harus diisi.',
            'numeric' => 'Data :attribute harus diisi dengan angka',
            'in' => 'Pilihan :attribute tidak tersedia',
            'email' => ':attribute tidak sesuai format email',
            'unique' => ':attribute sudah terdaftar dalam sistem',
            'mimes' => 'Data :attribute bukan file gambar',
            'uploaded' => 'Ukuran file :attribute melebihi 2Mb'
        ];
    }
}
