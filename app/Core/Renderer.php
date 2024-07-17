<?php

namespace App\Core;

use App\Html\Template;

class Renderer
{
    private array $template;

    private bool $error = false;

    public function render($file)
    {
        try {
            ob_start();
            include($file);
            $content = ob_get_contents();
            ob_end_clean();
        } catch (\Throwable $th) {
            ob_end_clean();
            $this->error = true;
            $content = '<h1>Error Loading Page</h1><p>'.$th->getMessage().' '.$th->getFile().' '.$th->getLine().'</p>';
            //throw new \Exception("Error loading page ");
        }
        return $content;
    }

    public function renderTemplate($template, $args)
    {
        $renderArray = [];
        $this->error = false;

        if ($this->loadTemplate(dirname(__DIR__,1) . '/Html/Template/' . $template))
        {
            foreach ($this->template as $file)
            {
                $resolvedFile = $file;
                foreach ($args as $key => $value)
                {
                    $resolvedFile = str_replace('{' . $key . '}', $value, $resolvedFile);
                }

                $fileFullPath = dirname(__DIR__,1) . '/Html/'.$resolvedFile;
                if (file_exists($fileFullPath))
                {
                    $content = $this->render($fileFullPath);
                }
                else
                {
                    $this->error = true;
                    $content = '<h1>Error Loading Page</h1><p>'.$resolvedFile.'</p>';
                }

                if ($this->error)
                {
                    $renderArray = [];
                    $renderArray[] = $content;
                    break;
                }

                $renderArray[] = $content;
            }
        }
        else
        {
            return 'Render template failed';
        }

        return implode("\n", $renderArray);
    }

    private function loadTemplate($template): bool
    {
        try {
            $content = file_get_contents($template);
            $this->template = json_decode($content, true);
        } catch (\Exception $e)
        {
            return false;
        }

        return true;
    }
}