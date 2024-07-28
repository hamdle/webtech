<?php

namespace App\Controller;

use App\Core\Http\Response;

class PageController extends BaseController
{
    public function login(): Response
    {
        $this->renderHtmlTemplate('Login');
        return $this->response;
    }

    public function user(): Response
    {
        $this->renderHtmlTemplate('User');
        return $this->response;
    }

    public function home(): Response
    {
        $this->renderHtmlTemplate('Home');
        return $this->response;
    }
}
