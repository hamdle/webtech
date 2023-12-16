<?php

/*
 * Class Record
 *
 * A record from the database.
 * Models should extend this class and define these abstract functions.
 *
 * @author Eric Marty
 * @since 12-16-2023 1:16 PM
 */

namespace api\Core\Database;

abstract class Record
{
    use \api\Core\Traits\Messages;

    public $fields = [];

    private $id;

    abstract public function table();
    abstract public function formFieldValidationConfig();
    abstract public function formFieldTransformConfig();

    public function __construct($fields = [])
    {
        $this->fields = $fields;
    }

    public function __get($field)
    {
        return array_key_exists($field, $this->fields ?? [])
            ? $this->fields[$field]
            : null;
    }

    public function __set($field, $value)
    {
        $this->fields[$field] = $value;
    }

    // return = Id of inserted record | null
    public function save()
    {
        $this->transformFormFields();
        $id = Query::insert(
            $this->table(),
            array_keys($this->fields),
            array_values($this->fields));

        return $this->id = (is_numeric($id) ? $id : null);
    }

    public function loadFromDatabase()
    {
        $this->transformFormFields();
        $results = Query::select($this->table(), "*", $this->fields);

        if (is_array($results) && array_key_exists(0, $results))
        {
            foreach ($results[0] as $key => $value)
            {
                $this->fields[$key] = $value;
            }
        }
        else
        {
            $this->messages[] = ucfirst($this->table())." not found.";
            return false;
        }

        return true;
    }

    public function validateFormFields()
    {
        $this->messages = [];
        foreach ($this->formFieldValidationConfig() as $key => $validator)
        {
            if (array_key_exists($key, $this->fields))
            {
                if (($validationResponse = $validator($this->fields[$key])) !== true)
                    $this->messages[$key] = $validationResponse;
            }
        }
        return empty($this->messages);
    }

    public function transformFormFields()
    {
        foreach ($this->fields as $key => $field)
        {
            if (!array_key_exists($key, $this->formFieldValidationConfig()))
                unset($this->fields[$key]);
        }
        foreach ($this->formFieldTransformConfig() as $key => $transform)
        {
            if (array_key_exists($key, $this->fields))
                $this->fields[$key] = $transform($this->fields[$key]);
        }
    }
}
