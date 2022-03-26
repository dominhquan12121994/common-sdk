<?php

namespace Common\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

abstract class AbstractRequest extends FormRequest
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

    public function wantsJson()
    {
        return true;
        /*
        if(Str::contains($this->getRequestUri(), '/api'))
            return true;
        return parent::wantsJson();
        */
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        Log::info($errors);
        throw new HttpResponseException(response()->json(
            [
                'success' => false,
                'status_code' => 422,
                'errors' => $this->_prettyErrors($errors),
                'data' => array()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

    protected function _prettyErrors($errors){
        $failRules = $this->getValidatorInstance()->failed();
        return collect($errors)->map(function ($item, $key) use ($failRules) {
            $rule = array_key_first($failRules[$key]);
            $constant = '\Common\Exceptions\CommonErrorMessage::' . $rule;
            $error_code  = defined($constant) ? constant($constant) : \Common\Exceptions\CommonErrorMessage::Required;

            return array(
                'error_code' => $error_code,
                'message' => $item[0],
                'field_name' => $key
            );
        });
    }
}
