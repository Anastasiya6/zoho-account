<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealAccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'dealName' => 'required|string|max:255',
            'dealStage' => 'required|string|max:255',
            'accountName' => 'required|string|max:255',
            'accountWebsite' => 'required|url',
            'accountPhone' => 'required|string',
        ];
    }
}
