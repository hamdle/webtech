<?php

/*
 * Class UserSettingsForm
 *
 * User Settings form validation configuration.
 *
 * @author Eric Jawaid Marty
 * @since 12/27/23 3:37 PM
 */

namespace Api\Form;

class UserSettingsForm extends BaseForm
{
    protected function fieldValidation()
    {
        return [
            "first_name" => function ($entry) {
                return true;
            },
            "last_name" => function ($entry) {
                return true;
            },
        ];
    }
}