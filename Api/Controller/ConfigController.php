<?php

/*
 * Class ConfigController
 *
 *
 * @author Eric Jawaid Marty
 * @since 12/27/23 3:17 PM
 */

namespace Api\Controller;

use Api\Core\Database\Database;
use Api\Core\Http\Request;
use Api\Core\Http\Response;
use Api\Form\UserSettingsForm;
use Api\Form\WorkoutSettingsForm;
use Api\Form\SystemSettingsForm;
use Api\Model\User;
use Api\Rpc;

class ConfigController
{
    // POST :: api/config/saveUserSettings
    public function saveUserSettings()
    {
        $request = Request::post();
        $form = new UserSettingsForm();
        $user = Rpc::getUser();

        if ($form->validate($request))
        {
            $updatedUser = new User($request);
            $updatedUser->fields["id"] = $user->fields["id"];
            $updatedUser->save();

            return Response::sendOk();
        }

        return Response::sendOkWithWarning("validation failed");
    }

    // POST :: api/config/saveWorkoutSettings
    public function saveWorkoutSettings()
    {
        $request = Request::post();
        $form = new WorkoutSettingsForm();
        $user = Rpc::getUser();
        if ($form->validate($request))
        {
            Database::update(
                "system_config",
                ["data"],
                [$request["rep_rest_default"]],
                "user_id = ".$user->fields["id"].
                " and reference = 'rep_rest_default'"
            );
            Database::update(
                "system_config",
                ["data"],
                [$request["set_rest_default"]],
                "user_id = ".$user->fields["id"].
                " and reference = 'set_rest_default'"
            );
            Database::update(
                "system_config",
                ["data"],
                [$request["pagination_default"]],
                "user_id = ".$user->fields["id"].
                " and reference = 'pagination_default'"
            );
            Database::update(
                "system_config",
                ["data"],
                [$request["play_timer_sound"]],
                "user_id = ".$user->fields["id"].
                " and reference = 'play_timer_sound'"
            );

            return Response::sendOk();
        }

        return Response::sendOkWithWarning("validation failed");
    }

    // POST :: api/config/saveSystemSettings
    public function saveSystemSettings()
    {
        $request = Request::post();
        $form = new SystemSettingsForm();
        $user = Rpc::getUser();
        if ($form->validate($request))
        {
            Database::update(
                "system_config",
                ["data"],
                [$request["default_timezone"]],
                "user_id = ".$user->fields["id"].
                " and reference = 'default_timezone'"
            );

            return Response::sendOk();
        }

        return Response::sendOkWithWarning("validation failed");
    }
}