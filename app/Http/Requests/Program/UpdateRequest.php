<?php

namespace App\Http\Requests\Program;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        $rules = [];
        // $rules['name'] = 'required';
        // $rules['short_description'] = 'required';
        // $rules['description'] = 'required';
        $rules['slug'] = 'required|unique:programs,slug,'.$this->id;
        // $rules['category'] = 'required|in:competition,talkshow';
        // $rules['comittee_id'] = 'required';
        // $rules['price'] = 'required|integer|min:0';

        // if($this->get('category') == 'competition'){
        //     $rules['max_team'] = 'required|integer|min:0';
        //     $rules['group_settings'] = 'required';
        //     $rules['themes.*'] = 'required';
        // }

        // if(
        //     $this->get('stage_1_open_registration') != null ||
        //     $this->get('stage_1_close_registration') != null ||
        //     $this->get('stage_1_start_selection') != null ||
        //     $this->get('stage_1_end_selection') != null ||
        //     $this->get('stage_1_announcement') != null
        // ){
        //     $rules['stage_1_open_registration'] = 'required';
        //     $rules['stage_1_close_registration'] = 'required|after_or_equal:stage_1_open_registration';
        //     $rules['stage_1_start_selection'] = 'required|after_or_equal:stage_1_close_registration';
        //     $rules['stage_1_end_selection'] = 'required|after_or_equal:stage_1_start_selection';
        //     // $rules['stage_1_announcement'] = 'required|after_or_equal:stage_1_end_selection';
        // }

        // if(
        //     $this->get('stage_2_open_registration') != null ||
        //     $this->get('stage_2_close_registration') != null ||
        //     $this->get('stage_2_start_selection') != null ||
        //     $this->get('stage_2_end_selection') != null ||
        //     $this->get('stage_2_announcement') != null
        // ){
        //     $rules['stage_2_open_registration'] = 'required|after_or_equal:today';
        //     $rules['stage_2_close_registration'] = 'required|after_or_equal:stage_2_open_registration';
        //     $rules['stage_2_start_selection'] = 'required|after_or_equal:stage_2_close_registration';
        //     $rules['stage_2_end_selection'] = 'required|after_or_equal:stage_2_start_selection';
        //     // $rules['stage_2_announcement'] = 'required|after_or_equal:stage_2_end_selection';
        // }

        // if(
        //     $this->get('stage_3_open_registration') != null ||
        //     $this->get('stage_3_close_registration') != null ||
        //     $this->get('stage_3_start_selection') != null ||
        //     $this->get('stage_3_end_selection') != null ||
        //     $this->get('stage_3_announcement') != null
        // ){
        //     $rules['stage_3_open_registration'] = 'required|after_or_equal:today';
        //     $rules['stage_3_close_registration'] = 'required|after_or_equal:stage_3_open_registration';
        //     $rules['stage_3_start_selection'] = 'required|after_or_equal:stage_3_close_registration';
        //     $rules['stage_3_end_selection'] = 'required|after_or_equal:stage_3_start_selection';
        //     // $rules['stage_3_announcement'] = 'required|after_or_equal:stage_3_end_selection';
        // }

        return $rules;
    }

    public function attributes()
    {
        return [
            'comittee_id' => 'contact person'
        ];
    }
}
