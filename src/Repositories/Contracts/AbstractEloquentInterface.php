<?php

namespace Common\Repositories\Contracts;

interface AbstractEloquentInterface
{
    public function getConnection();

    public function getAll();

    public function getById($id);

    public function getOne($conditions = array(), $fetchOptions = array());

    public function getMore($conditions = array(), $fetchOptions = array(), $paginate = false);

    public function create($data = array());

    public function insert($listData = array());

    public function delByCond($conditions = array());

    public function destroy($listData = array());

    public function updateByCondition($conditions = array(), $fillData = array());

    public function updateById($id, $fillData = array());

    public function checkExist($conditions);
}
