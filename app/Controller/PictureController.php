<?php

namespace App\Controller;

use App\Core\Http\Request;
use App\Core\Http\Response;

class PictureController extends BaseController
{
    public function takepicture($args): Response
    {
        $this->response->setJson();

        $data = $args;
        $fileName = str_replace("'", "", $data["name"]) ?? null;
        $key = $data["key"] ?? null;
        $image = $data["image"] ?? null;

        if (!$fileName || !$image || $key != "SANGEAN6666!") {
            $this->response->setContent([
                "error" => "true",
                "message" => "Invalid data.",
            ]);
            return $this->response;
        }

        $base64decodedString = base64_decode($image);
        file_put_contents
        (
            $_SERVER["DOCUMENT_ROOT"] . "/takepicture/".$fileName,
            $base64decodedString
        );

        $this->response->setContent([
            "error" => "false",
            "message" => "Picture uploaded.",
            "name" => $fileName,
        ]);
        return $this->response;
    }

    public function ping($args): Response
    {
        $this->response->setJson();
        $this->response->setContent([
            "error" => "false",
            "message" => "pong",
        ]);
        return $this->response;
    }

    public function page(): Response
    {
        $this->renderHtmlTemplate('Takepicture');
        return $this->response;
    }

    public function list(): array
    {
        $list = [];
        $dir = $_SERVER["DOCUMENT_ROOT"] . "/takepicture/";
        $scan = scandir($dir);
        foreach ($scan as $file)
        {
            if ($file != "." && $file != ".." && $file != "index.php")
            {
                $list[] = $file;
            }
        }
        usort($list, function ($a, $b) {
            $part1 = explode(" - ", $a);
            $part2 = explode("-", $part1[1]);
            $adt = $part2[0];

            $part1 = explode(" - ", $b);
            $part2 = explode("-", $part1[1]);
            $bdt = $part2[0];

           return  strtotime($bdt) - strtotime($adt);
        });

        return $list;
    }
}