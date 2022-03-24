<?php

namespace Internexus\Larapid\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LarapidRequest extends FormRequest
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
        $validators = [];
        $entity = $this->entity;
        $method = $this->method();
        $fields = $this->id ? $entity->getUpdatingFields() : $entity->getCreatingFields();

        foreach ($fields as $column => $field) {
            $rules = $field->getRules();

            if ($method == 'POST') {
                $rules =  array_merge($rules, $field->getCreationRules());
            } else if ($method == 'PUT') {
                $rules = array_merge($rules, $field->getUpdateRules());
            }

            $validators[$column] = $rules;
        }

        return $validators;
    }
}
