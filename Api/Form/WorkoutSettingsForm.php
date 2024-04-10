<?php

/*
 * Class WorkoutSettingsForm
 *
 * Workout Settings form validation configuration.
 *
 * @author Eric Jawaid Marty
 * @since 12/27/23 11:56 PM
 */

namespace Api\Form;

class WorkoutSettingsForm extends BaseForm
{
    protected function fieldValidation()
    {
        return [
            "rep_rest_default" => function ($entry) {
                return true;
            },
            "set_rest_default" => function ($entry) {
                return true;
            },
            "pagination_default" => function ($entry) {
                return true;
            },
        ];
    }
}