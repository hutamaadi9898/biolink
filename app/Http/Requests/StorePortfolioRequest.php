<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePortfolioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'link' => 'nullable|url|max:500',
            'category' => 'required|string|in:web,mobile,design,other',
            'image' => 'required|image|max:5120', // 5MB max
            'order' => 'nullable|integer|min:0',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul portfolio wajib diisi.',
            'title.max' => 'Judul portfolio maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
            'link.url' => 'Link harus berupa URL yang valid.',
            'link.max' => 'Link maksimal 500 karakter.',
            'category.required' => 'Kategori wajib dipilih.',
            'category.in' => 'Kategori yang dipilih tidak valid.',
            'image.required' => 'Gambar portfolio wajib diupload.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 5MB.',
            'order.integer' => 'Urutan harus berupa angka.',
            'order.min' => 'Urutan tidak boleh kurang dari 0.',
        ];
    }
}
