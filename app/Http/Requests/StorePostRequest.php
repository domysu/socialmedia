<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Auth;


class StorePostRequest extends FormRequest
{

    public static $extensions =
    [
        'jpg', 'png', 'webp',
        'mp3', 'wav', 'mp4',
        'docx', 
    ];
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
            'attachments.*' => [
                'file',
                File::types(self::$extensions)->max('500mb')

            ],
            'body' => ['string'],
            'user_id'=> ['numeric']
        ];
    }

    protected function prepareForValidation()
    {
    $this->merge([ 

        'user_id' => Auth::id(),
    ]);
    }
    public function messages(){

        return[
            'attachments.*' => 'Invalid file',  

        ];
    }
}
