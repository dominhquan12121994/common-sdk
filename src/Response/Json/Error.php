<?php

namespace Common\Response\Json;

use Illuminate\Routing\ResponseFactory;
use Common\Response\Contracts\ResponseAbstract;
use Common\Response\Contracts\ResponseInterface;

/**
 * Class Error
 * @package Common\Response\Json
 */
class Error extends ResponseAbstract implements ResponseInterface
{
    /**
     * @param ResponseFactory $factory
     * @return mixed|void
     */
    public function run(ResponseFactory $factory)
    {
        $factory->macro('responseError', function ($messages = array(), $appendData = array(), $statusCode = 400) use ($factory) {
            $messages = is_array($messages) ? $messages : array($messages);
            $response = array(
                'success' => false,
                'status_code' => $statusCode,
                'errors' => $messages,
                'data' => $appendData
            );

            return $factory->make($response, $statusCode);

        });
    }
}
