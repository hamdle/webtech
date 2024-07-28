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

    protected function renderHtmlTemplate($page): void
    {
        $this->response->setHtml();
        $content = $this->renderer->renderTemplate(
            'Page.json',
            ['page' => $page]
        );
        $this->response->setContent($content);
    }
}