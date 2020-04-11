<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'item' => 'required',
            'nama' => 'required',
            'phone' => 'required|numeric',
            'pesan' => 'required',
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
