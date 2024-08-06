<?php

/*
 * Class TimelogController
 *
 * Control special endpoints for Timelog application.
 *
 * @author Eric Marty
 * @since 07/5/2024 6:48 PM
 */

namespace App\Controller;

use App\Core\Http\Response;
use App\Model\Timesheet;
use App\Rpc;

class TimelogController extends BaseController {
    public function timesheet($args): Response
    {
        $this->response->setJson();

        $file = $args["timesheet"] ?? null;
        $tag = $args["tag"] ?? null;
        if (!$file || !$tag) {
            $this->response->setContent([
                "error" => "true",
                "message" => "Invalid data.",
            ]);
            return $this->response;
        }
        $file = json_decode($file);
        $file = implode("", $file);

        $user = $user = \App\Core\Context::get('user');

        $timesheet = new Timesheet([
            'tag' => $tag,
            'user_id' => $user->fields["id"]
        ]);
        $timesheet->loadFromDatabase();
        $timesheet->fields["file"] = $file;
        $timesheet->save();

        $this->response->setContent([
            "error" => "false",
            "message" => "Timelog saved successfully.",
        ]);
        return $this->response;
    }
}
