<?php

namespace App\Controller;

use App\Core\Http\Response;

class PageController extends BaseController
{
    private function renderResponse($page): Response
    {
        $this->response->setHtml();
        $content = $this->renderer->renderTemplate(
            'Page.json',
            ['page' => $page]
        );

        $this->response->setContent($content);
        return $this->response;
    }

    public function login(): Response
    {
        return $this->renderResponse('Login');
    }

    public function home(): Response
    {
        return $this->renderResponse('Home');
    }

    public function go(): Response
    {
        return $this->renderResponse('Go');
    }

    public function user(): Response
    {
        return $this->renderResponse('User');
    }
}
