<?php

/*
 * Class SystemSettingsForm
 *
 * System Settings form validation configuration.
 *
 * @author Eric Jawaid Marty
 * @since 12/28/23 11:28 PM
 */

namespace Api\Form;

class SystemSettingsForm extends BaseForm
{
    protected function fieldValidation()
    {
        return [
            "default_timezone" => function ($entry) {
                return true;
            },
        ];
    }
}