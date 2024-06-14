<?php

namespace Api\Controller;

class PageController extends BaseController
{
    public function test()
    {
        $this->response->setHtml();

        //$content = $this->renderer->render(dirname(__DIR__,1) . '/Html/Page/index.php');

        $content = $this->renderer->renderTemplate(
            'Page.json',
            ['page' => 'Test']
        );

        $this->response->setContent($content);

        return $this->response;
    }
}
