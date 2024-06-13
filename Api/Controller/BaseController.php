<?php

namespace Api\Controller;

use Api\Core\Http\Response;
use Api\Core\Renderer;

class BaseController
{
    protected Response $response;

    protected Renderer $renderer;

    public function __construct()
    {
        $this->response = new Response();
        $this->renderer = new Renderer();
    }
}