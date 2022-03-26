<?php

namespace Common\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PalException extends AbstractException {
    public function __construct($errorCode = 'ERR_001', $message = 'Error', $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $constant = 'ErrorMessage::' . $errorCode;
        $message  = defined($constant) ? constant($constant) : ErrorMessage::ERR_001;
        $this->statusCode = $statusCode;
        $this->errorCode  = $errorCode;
        $this->message    = $message;

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
            'data'      => array()
        );

        return response()->json($response, $this->statusCode);
    }
}