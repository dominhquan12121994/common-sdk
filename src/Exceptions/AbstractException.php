<?php

namespace Common\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

abstract class AbstractException extends Exception
{
    protected $statusCode;
    protected $errorCode;
    protected $message = '';

    public function __construct($errorCode = 'ERR_001', $message = 'Error', $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $this->statusCode = $statusCode;
        $this->errorCode  = $errorCode;
        $this->message    = $message;

        parent::__construct($message, $statusCode);
    }

    public function render(Request $request)
    {
        $error = new \stdClass();
        $error->code    = $this->errorCode;
        $error->message = $this->message;

        $response = array(
            'success'   => false,
            'status_code' => $this->statusCode,
            'errors'    => array($error),
            'data'      => array()
        );

        return response()->json($response, $this->statusCode);
    }

    public function report()
    {
        Log::debug($this->message);
    }
}
