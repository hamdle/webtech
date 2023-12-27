<?php

/*
 * Class LoginForm
 *
 * Login form validation configuration.
 *
 * @author Eric Jawaid Marty
 * @since 12/27/23 12:23 PM
 */

namespace api\Form;

class LoginForm
{
    use \api\Core\Traits\Messages;

    public function validate($request)
    {
        $this->messages = [];
        foreach ($this->fieldValidation() as $key => $validator)
        {
            if (array_key_exists($key, $request) &&
                ($validationResponse = $validator($request[$key])) !== true)
            {
                $this->messages[$key] = $validationResponse;
            }
        }
        return empty($this->messages);
    }

    private function fieldValidation()
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