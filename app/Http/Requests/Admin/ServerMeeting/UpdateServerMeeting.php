<?php

namespace App\Http\Requests\Admin\ServerMeeting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateServerMeeting extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.server-meeting.edit', $this->serverMeeting);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'server_id' => ['sometimes', 'integer'],
            'meeting_id' => ['sometimes', 'string'],
            'meeting_name' => ['sometimes', 'string'],
            'status' => ['sometimes', 'string'],
            'start_time' => ['sometimes', 'date'],

        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();


        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
