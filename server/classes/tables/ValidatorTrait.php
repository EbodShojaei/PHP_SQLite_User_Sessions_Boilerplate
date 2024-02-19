<?php

/**
 * Trait to validate and sanitize input data.
 */
trait ValidatorTrait
{
    /**
     * Sanitizes the input data.
     *
     * @param string $data The data to sanitize.
     * @return string The sanitized data.
     */
    protected function sanitize_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * Validates a string.
     *
     * @param string $string The string to validate.
     * @param int $max_length The maximum length of the string.
     * @param string $field_name The name of the field being validated. Default is "Input".
     */
    private function validate_string(string $string, int $max_length, string $field_name = "Input")
    {
        $string = $this->sanitize_input($string);
        if (strlen($string) == 0) throw new InvalidArgumentException("$field_name cannot be empty");
        if (strlen($string) > $max_length) throw new InvalidArgumentException("$field_name cannot be more than " . $max_length . " characters.");
    }

    /**
     * Validates an ID.
     *
     * @param int $id The ID to validate.
     */
    private function validate_id(int $id)
    {
        $id = $this->sanitize_input($id);
        if (strlen($id) == 0) throw new InvalidArgumentException("ID cannot be empty");
        if (!is_numeric($id)) throw new InvalidArgumentException("ID must be a number");
        if ($id <= 0) throw new InvalidArgumentException("ID must be greater than 0");
        if ($id != round($id)) throw new InvalidArgumentException("ID must be an integer");
        if ($id > $this->get_row_count()) throw new InvalidArgumentException("ID does not exist");
    }

    /**
     * Validates the input for a date.
     *
     * @param string $date The date to validate.
     */
    private function validate_date(string $date)
    {
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
            throw new InvalidArgumentException("Date must be in the format 'YYYY-MM-DD'.");
        }
    }
}
