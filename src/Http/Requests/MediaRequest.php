<?php

namespace Internexus\Larapid\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
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
     * Get size rule.
     *
     * @param mixed $size
     * @return string
     */
    protected function getSize($size)
    {
        return 'max:' . intval($size) / 1000;
    }

    /**
     * Get mimes rule.
     *
     * @param mixed $size
     * @return string
     */
    protected function getMimes($mimes)
    {
        return 'mimes:' . implode(',', $mimes);
    }

    /**
     * Get dimensions rule.
     *
     * @param mixed $size
     * @return string
     */
    protected function getDimensionRules($dimensions)
    {
        $rules = [];

        foreach (['min', 'max'] as $dimension) {
            foreach (['width', 'height'] as $size) {
                $prop = $dimension . ucfirst($size);

                if (property_exists($dimensions, $prop)) {
                    $value = $dimensions->{$prop};

                    if ($value) {
                        $rules[] = "{$dimension}_{$size}={$value}";
                    }
                }
            }
        }

        if (count($rules) > 0) {
            return 'dimensions:' . implode(',', $rules);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $options = json_decode($this->options);

        $rules =  [
            'required',
            $this->getSize($options->maxSize),
            $this->getMimes($options->mimes),
            $this->getDimensionRules($options->dimensions)
        ];

        return [
            'file' => $rules,
        ];
    }
}
