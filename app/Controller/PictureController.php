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
}