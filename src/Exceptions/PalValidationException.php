<?php

namespace Common\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PalValidationException extends AbstractException
{
    protected $validator;

    public function __construct($validator, $errorCode = 'ERR_003', $message = 'Error', $statusCode = Response::HTTP_BAD_REQUEST)
    {
        $constant = 'ErrorMessage::' . $errorCode;
        $message  = defined($constant) ? constant($constant) : ErrorMessage::ERR_003;
        $this->statusCode = $statusCode;
        $this->errorCode  = $errorCode;
        $this->message    = $message;
        $this->validator  = $validator;

        parent::__construct($errorCode, $message, $statusCode);
    }

    public function render(Request $request)
    {
        $error = new \stdClass();
        $error->code    = $this->errorCode;
        $error->message = $this->message;

        $response = array(
            'success'   => false,
            'status_code' => $this->statusCode,
            'errors'    => $error,
            'data'      => $this->validator->errors()
        );

        return response()->json($response, $this->statusCode);
    }
}