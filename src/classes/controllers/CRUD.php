<?php

interface CRUD
{
    public function create($data);
    public function read($id);
    public function update($data);
    public function delete($id);
}
