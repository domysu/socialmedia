<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

use function Pest\Laravel\post;

class UpdatePostRequest extends FormRequest
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
            return $this->post->user_id == Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    
    public function rules(): array 
    {
        return [ 
            'body' =>       ['string'],
            'user_id' =>    'numeric', 
            'attachments' => 'array|max:10',
            'attachments.*' => [
                'file',
                File::types(self::$extensions)->max('500mb')

            ],
        ];
    }

    public function messages(){

        return[
            'attachments.*' => 'Invalid file',  

        ];
    }
}
