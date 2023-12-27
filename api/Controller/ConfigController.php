<?php

/*
 * Class ConfigController
 *
 *
 * @author Eric Jawaid Marty
 * @since 12/27/23 3:17 PM
 */

namespace api\Controller;

use api\Core\Http\Request;
use api\Core\Http\Response;
use api\Form\UserSettingsForm;
use api\Model\User;
use api\Rpc;

class ConfigController
{
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
}