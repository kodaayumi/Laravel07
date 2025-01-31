<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'comment' => 'nullable|string',
            'user_id' => 'required|exists:users,id', // ユーザー名の存在確認
            'task_status' => 'required|integer|in:1,2,3,4', // タスクステータスの範囲確認
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'タスク名は必須です。',
            'user_id.required' => '担当者は必須です。',
            'task_status.required' => 'ステータスは必須です。',
            'task_status.in' => '無効なステータスが選択されました。',
        ];
    }
}
