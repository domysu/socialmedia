<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use App\Http\Requests\StorePostRequest;



class UpdatePostRequest extends StorePostRequest
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
       return parent::rules();
    }

    public function messages(){

        return[
            'attachments.*' => 'Invalid file type',
            'attachments.*.max' => 'The file size must not exceed 500MB',

        ];
    }
}
