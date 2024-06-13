<?php

namespace Api\Controller;

class PageController extends BaseController
{
    public function test()
    {
        $this->response->setHtml();

        $content = $this->renderer->render(dirname(__DIR__,1) . '/Html/Page/index.php');
        //$this->renderer->renderTemplate('page', 'test');
        $this->response->setContent($content);

        return $this->response;
    }
}
