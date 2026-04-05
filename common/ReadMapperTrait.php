<?php

namespace app\common;

use yii\db\Connection;
use yii\db\Query;

trait ReadMapperTrait
{
    abstract protected function getConnection(): Connection;
    abstract protected function tableName(): string;
    abstract protected function arrayToEntity(array $array);

    public function existsById(int $id)
    {
        return $this->find()
            ->where([$this->tableName() . '.id' => $id])
            ->exists($this->getConnection());
    }

    public function findOneById(int $id)
    {
        $array = $this->find()
            ->where([$this->tableName() . '.id' => $id])
            ->one($this->getConnection());
        return $array ? $this->arrayToEntity($array) : null;
    }

    public function findSlice(int $offset, int $limit)
    {
        $arrays = $this->find()
            ->offset($offset)
            ->limit($limit)
            ->all($this->getConnection());
        $entities = [];
        foreach ($arrays as $array) {
            $entities[] = $this->arrayToEntity($array);
        }
        return $entities;
    }

    public function countAll()
    {
        return $this->find()->count('*', $this->getConnection());
    }

    private function find()
    {
        $query = new Query()->from($this->tableName());
        $query = $this->withRelations($query);
        $query = $this->select($query);
        return $query;
    }

    protected function select(Query $query)
    {
        return $query->select($this->tableName() . '.*');
    }

    protected function withRelations(Query $query)
    {
        return $query;
    }

}