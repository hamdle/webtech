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

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Model\User;
use App\Form\LoginForm;
use App\Core\Authentication\Session;
use App\Rpc;

class TimelogController extends BaseController {
    public function timesheet($args): Response
    {
        $this->response->setJson();

        $timesheet = $args["timesheet"] ?? null;
        if (!$timesheet) {
            $this->response->setContent([
                "error" => "true",
                "message" => "Invalid data.",
            ]);
            return $this->response;
        }
        $timesheet = json_decode($timesheet);
        $data = implode("", $timesheet);

        // TODO: Save $data to database

        $this->response->setContent([
            "message" => "Timelog saved successfully.",
        ]);
        return $this->response;
    }
}
