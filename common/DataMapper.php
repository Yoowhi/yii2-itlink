<?php

namespace app\common;

use yii\db\Connection;
use yii\db\Query;

abstract class DataMapper
{
    protected abstract function getConnection(): Connection;
    protected abstract function tableName(): string;

    public function countAll()
    {
        $result = new Query()
            ->count('*', $this->getConnection());
        return (int)$result;
    }

    public function existsById(int $id)
    {
        return new Query()
            ->where([$this->tableName() . '.id' => $id])
            ->exists($this->getConnection());
    }
}