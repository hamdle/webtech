<?php

namespace Api\Controller;

class PageController extends BaseController
{
    public function login()
    {
        $this->response->setHtml();
        $content = $this->renderer->renderTemplate(
            'Page.json',
            ['page' => 'Login']
        );

        $this->response->setContent($content);
        return $this->response;
    }

    public function home()
    {
        $this->response->setHtml();
        $content = $this->renderer->renderTemplate(
            'Page.json',
            ['page' => 'Home']
        );

        $this->response->setContent($content);
        return $this->response;
    }

    public function go()
    {
        $this->response->setHtml();
        $content = $this->renderer->renderTemplate(
            'Page.json',
            ['page' => 'Go']
        );

        $this->response->setContent($content);
        return $this->response;
    }
}
