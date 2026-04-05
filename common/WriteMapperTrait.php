<?php

namespace app\common;

use yii\base\Exception;
use yii\db\Connection;

trait WriteMapperTrait
{
    abstract protected function getConnection(): Connection;
    abstract protected function tableName(): string;
    abstract protected function entityToArray($entity): array;

    public function insert($entity)
    {
        $result = $this->getConnection()
            ->createCommand()
            ->insert($this->tableName(), $this->entityToArray($entity))
            ->execute();
        if ($result === 0) {
            throw new Exception("Couldn't save entity to " . $this->tableName());
        }
        $entity->id = $this->getConnection()->getLastInsertID();
        return $entity;
    }

    public function update($entity)
    {
        $this->getConnection()
            ->createCommand()
            ->update($this->tableName(), $this->entityToArray($entity))
            ->execute();
        return $entity;
    }
}