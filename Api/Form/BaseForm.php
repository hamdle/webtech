<?php

/*
 * Class BaseForm
 *
 * Form validation configuration base class.
 *
 * @author Eric Jawaid Marty
 * @since 12/27/23 3:38 PM
 */

namespace Api\Form;

abstract class BaseForm
{
    use \Api\Core\Traits\Messages;

    abstract protected function fieldValidation();

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
}