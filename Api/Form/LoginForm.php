<?php

/*
 * Class LoginForm
 *
 * Login form validation configuration.
 *
 * @author Eric Jawaid Marty
 * @since 12/27/23 12:23 PM
 */

namespace Api\Form;

class LoginForm extends BaseForm
{
    protected function fieldValidation()
    {
        return [
            "email" => function ($entry) {
                if (empty($entry))
                    return "Email address should not be empty.";
                return true;
            },
            "password" => function ($entry) {
                if (empty($entry))
                    return "Password should not be empty.";
                return true;
            },
        ];
    }
}