<?php


namespace Informatics\Base\Repositories\Interfaces;

interface BaseOperationsInterface
{
    public function insert($data);

    public function update($data, $id);

    public function delete($id);

    public function find($id);
}