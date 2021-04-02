<?php

namespace App\Services;

interface IDefault
{
    public function create($input);
    public function update($id, $input);
    public function delete($id);
    public function findById($id);
}
