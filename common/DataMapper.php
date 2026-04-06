<?php

namespace app\common;

use yii\db\Connection;
use yii\db\Query;

abstract class DataMapper
{
    /**
     * Должен возвращать Connection, полученный дочерним классом через DI
     */
    protected abstract function getConnection(): Connection;

    /**
     * Название таблицы
     */
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