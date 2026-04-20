<?php

namespace app\common;

use yii\base\Exception;
use yii\db\Connection;

trait WriteMapperTrait
{
    abstract protected function getConnection(): Connection;
    abstract protected function tableName(): string;

    /**
     * Должен вернуть стандартный для Command массив с данными
     */
    abstract protected function entityToArray($entity): array;

    public function insert($entity)
    {
        $result = $this->getConnection()
            ->createCommand()
            ->insert($this->tableName(), $this->entityToArray($entity))
            ->execute();
        if ($result === 0) {
            throw new Exception("Couldn't insert entity to " . $this->tableName());
        }
        $entity->id = $this->getConnection()->getLastInsertID();
        return $entity;
    }

    public function update($entity, $id)
    {
        if (is_null($id)) {
            throw new Exception("Couldn't update entity in " . $this->tableName() . ". Incorrect id: " . print_r($id, true));
        }
        $this->getConnection()
            ->createCommand()
            ->update($this->tableName(), $this->entityToArray($entity), ['id' => $id])
            ->execute();
        return $entity;
    }
}