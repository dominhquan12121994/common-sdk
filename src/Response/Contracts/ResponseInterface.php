<?php

namespace Common\Response\Contracts;

use Illuminate\Routing\ResponseFactory;

interface ResponseInterface
{
    /**
     * @param ResponseFactory $factory
     * @return mixed
     */
    public function run(ResponseFactory $factory);
}
