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
        if(isset($this->post->id))
        {
            return $this->post->user_id == Auth::id();
        }
        else return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'attachments' => ['array',
            'max:50',
            function($attribute, $value, $fail){
                $totalSize = collect($value)->sum(fn($file) => $file->getSize());

                if($totalSize > 1  * 1024 * 1024 * 1024){ // 1024 * 1024 * 1024 = 1GB  
                    $fail('The total size of attachments must not exceed 1GB ');
                }
                },  
        ],
            'attachments.*' => [
                'file',
                File::types(self::$extensions),
                'max:500000' // 500MB


            ],
            'body' => ['string'],
            'user_id'=> ['numeric']
        ];
    }

    protected function prepareForValidation()
    {
    $this->merge([ 

        'user_id' => Auth::id(), // why its needed is because the user_id is not in the form
    ]);
    }
    public function messages(){

        return[
            'attachments.*' => 'Invalid file type',
            'attachments.*.max' => 'The file size must not exceed 500MB',

        ];
    }
}
