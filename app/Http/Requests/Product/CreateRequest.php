<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
    
    public function prepareForValidation()
    {
        if (isset($this->request->all()['data'])) {
            parse_str(($this->request->all()['data']), $arr);

            foreach ($arr as $key => $value) {
                $this->request->set($key, $value);
            }
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'      => 'required|max:191',
            'price'     => 'required|max:191',
            'quantity'  => 'required|max:191',
            'files'     => 'numeric|min:1',
            'category_id'   => 'required',
        ];

        return $rules;     
    }
}
