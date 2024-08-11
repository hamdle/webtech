<?php

/*
 * Class ConfigController
 *
 *
 * @author Eric Jawaid Marty
 * @since 12/27/23 3:17 PM
 */

namespace App\Controller;

use App\Core\Database\Database;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Form\UserSettingsForm;
use App\Form\WorkoutSettingsForm;
use App\Form\SystemSettingsForm;
use App\Model\User;
use App\Rpc;

class ConfigController extends BaseController
{
    public function saveUserSettings($args)
    {
        $this->response->setJson();

        $form = new UserSettingsForm();
        $user = \App\Core\Context::get('user');

        if ($form->validate($args))
        {
            $updatedUser = new User($args);
            $updatedUser->fields["id"] = $user->fields["id"];
            $updatedUser->save();

            $this->response->setContent([
                "error" => "false",
            ]);
            return $this->response;
        }

        $this->response->setContent([
            "error" => "false",
            "warning" => "validation failed",
        ]);
        return $this->response;
    }

    public function saveWorkoutSettings($args)
    {
        $this->response->setJson();
        $form = new WorkoutSettingsForm();
        $user = \App\Core\Context::get('user');
        if ($form->validate($args))
        {
            Database::update(
                "system_config",
                ["data"],
                [$args["rep_rest_default"]],
                "user_id = ".$user->fields["id"].
                " and reference = 'rep_rest_default'"
            );
            Database::update(
                "system_config",
                ["data"],
                [$args["set_rest_default"]],
                "user_id = ".$user->fields["id"].
                " and reference = 'set_rest_default'"
            );
            Database::update(
                "system_config",
                ["data"],
                [$args["pagination_default"]],
                "user_id = ".$user->fields["id"].
                " and reference = 'pagination_default'"
            );
            Database::update(
                "system_config",
                ["data"],
                [$args["play_timer_sound"]],
                "user_id = ".$user->fields["id"].
                " and reference = 'play_timer_sound'"
            );

            $this->response->setContent([
                "error" => "false",
            ]);
            return $this->response;
        }

        $this->response->setContent([
            "error" => "false",
            "warning" => "validation failed",
        ]);
        return $this->response;
    }

    public function saveTakepictureSettings($args)
    {
        $this->response->setJson();
        $form = new WorkoutSettingsForm();
        $user = \App\Core\Context::get('user');
        if ($form->validate($args))
        {
            Database::update(
                "system_config",
                ["data"],
                [$args["takepicture_purge_days"]],
                "user_id = 1".
                " and reference = 'takepicture_purge_days'"
            );
            Database::update(
                "system_config",
                ["data"],
                [$args["ping_purge_days"]],
                "user_id = 1".
                " and reference = 'ping_purge_days'"
            );

            $this->response->setContent([
                "error" => "false",
            ]);
            return $this->response;
        }

        $this->response->setContent([
            "error" => "false",
            "warning" => "validation failed",
        ]);
        return $this->response;
    }

    public function saveSystemSettings($args)
    {
        $this->response->setJson();
        $form = new SystemSettingsForm();
        $user = \App\Core\Context::get('user');
        if ($form->validate($args))
        {
            Database::update(
                "system_config",
                ["data"],
                [$args["default_timezone"]],
                "user_id = ".$user->fields["id"].
                " and reference = 'default_timezone'"
            );

            $this->response->setContent([
                "error" => "false",
            ]);
            return $this->response;
        }

        $this->response->setContent([
            "error" => "false",
            "warning" => "validation failed",
        ]);
        return $this->response;
    }
}