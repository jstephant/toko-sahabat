<?php

namespace App\Services;

interface IDefaultDetail
{
    public function createDetail($input);
    public function updateDetail($id, $item_id, $input);
    public function deleteDetail($id, $item_id);
    public function deleteDetailAll($id);
    public function findDetailById($id);
}
