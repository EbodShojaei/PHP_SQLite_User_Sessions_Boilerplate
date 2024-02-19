<?php

/**
 * Interface for classes that manage SQLite tables.
 * Get records from the table.
 */
interface Readable
{
    /**
     * Get a record by its ID.
     * @param int $id The ID of the record to retrieve.
     * @return array The record's details.
     */
    public function get_by_id(int $id);

    /**
     * Get records by a max number of rows and an offset.
     * @param int|null $max_rows The maximum number of rows to display. Default is null to return all rows.
     * @param int $offset The number of rows to skip before starting to return data.
     */
    public function get_by_limit(int $max_rows = null, int $offset = 0);

    /**
     * Get all records from the table.
     * @return array The records.
     */
    public function get_all();

    /**
     * Get the total number of records in the table.
     * @return int The total number of records.
     */
    public function get_row_count();
}
