<?php

/**
 * Interface for classes that manage SQLite tables.
 * Insert, update, and remove records from the table.
 */
interface Editable
{
    /**
     * Insert a new record into the table.
     * @param array $data The record's details.
     * @return int The ID of the new record.
     */
    public function insert(array $data);

    /**
     * Update a record in the table.
     * @param int $id The ID of the record to update.
     * @param array $data The new details for the record.
     * @return bool True if the update was successful, false otherwise.
     */
    public function update(array $data);

    /**
     * Remove a record from the table.
     * @param int $id The ID of the record to remove.
     * @return bool True if the removal was successful, false otherwise.
     */
    public function remove(int $id);
}
