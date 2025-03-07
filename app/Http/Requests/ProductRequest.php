<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        // I'd prefer using policies
        return auth()->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:physical,digital',
            'weight' => 'nullable|numeric|min:0', // Required only for physical products
            'width' => 'nullable|numeric|min:0', // Required only for physical products
            'height' => 'nullable|numeric|min:0', // Required only for physical products
            'length' => 'nullable|numeric|min:0', // Required only for physical products
            'download_url' => 'nullable|url', // Required only for digital products
        ];
    }
}
