<?php

namespace Api\Core;

class Renderer
{
    public function render($file)
    {
        try {
            ob_start();
            include($file);
            $content = ob_get_contents();
            ob_end_clean();
        } catch (\Throwable $th) {
            ob_end_clean();
            $content = '<h1>Error Loading Page</h1><p>'.$th->getMessage().' '.$th->getFile().' '.$th->getLine().'</p>';
            //throw new \Exception("Error loading page ");
        }
        return $content;
    }
}