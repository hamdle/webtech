<?php

namespace App\Controller;

use App\Core\Http\Response;
use App\Core\Renderer;

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