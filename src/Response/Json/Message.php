<?php

namespace Common\Response\Json;

use Illuminate\Routing\ResponseFactory;
use Common\Response\Contracts\ResponseAbstract;
use Common\Response\Contracts\ResponseInterface;

/**
 * Class Message
 * @package Common\Response\Json
 */
class Message extends ResponseAbstract implements ResponseInterface
{
    /**
     * @param ResponseFactory $factory
     * @return mixed|void
     */
    public function run(ResponseFactory $factory)
    {
        $factory->macro('responseMessage', function ($messages = 'Success', $appendData = array(), $statusCode = 200, $success = true) use ($factory) {
            $response = array(
                'status_code' => $statusCode,
                'success' => $success,
                'message' => $messages,
                'data' => $appendData
            );

            return $factory->make($response, $statusCode);
        });
    }
}
