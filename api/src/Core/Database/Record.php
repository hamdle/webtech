<?php

/*
 * Core/Database/Record.php: a record from the database
 *
 * Models should extend this class and define these abstract functions.
 *
 * Copyright (C) 2021 Eric Marty
 */

namespace Core\Database;

abstract class Record
{
    use \Core\Traits\Messages;

    public $fields = [];

    // Define these functions in the model
    abstract public function table();
    abstract public function config();
    abstract public function transforms();

    public function __construct($fields = [])
    {
        $this->fields = $fields;
    }

    public function __get($field)
    {
        return $this->get($field);
    }

    public function __set($field, $value)
    {
        $this->fields[$field] = $value;
    }

    private function get($field)
    {
        if (array_key_exists($field, $this->fields ?? []))
            return $this->fields[$field];
        else
            return null;
    }

    // return = Id of inserted record | null
    public function save()
    {
        $this->filter();
        $this->transform();

        $id = Query::insert(
            $this->table(),
            array_keys($this->fields),
            array_values($this->fields));

        return $this->id = (is_numeric($id) ? $id : null);
    }

    // Run validation using defined config() and return error messages.
    //return bool = true | false with messages set
    public function validate()
    {
        if (($results = $this->validation($this->config())) !== true)
        {
            $this->messages[] = $results;
            return false;
        }

        return true;
    }

    // Run fields through the config() validation functions.
    // TODO revise this return to include messages
    // return bool = true | false with messages set
    public function validation($config)
    {
        // TODO Can this function call $this->config() directly?
        if (!isset($this->fields))
            return false;

        $messages = [];
        foreach ($config as $key => $validator)
        {
            if (array_key_exists($key, $this->fields))
            {
                if (($validationResponse = $validator($this->fields[$key])) !== true)
                    $messages[$key] = $validationResponse;
            }
        }

        return empty($messages) ? true : $messages;
    }

    // Filter out fields that are not in the config.
    public function filter()
    {
        foreach ($this->fields as $key => $field)
        {
            if (!array_key_exists($key, $this->config()))
                unset($this->fields[$key]);
        }
    }

    // Run fields through input transforms.
    public function transform()
    {
        foreach ($this->transforms() as $key => $transform)
        {
            if (array_key_exists($key, $this->fields))
                $this->fields[$key] = $transform($this->fields[$key]);
        }
    }
}
