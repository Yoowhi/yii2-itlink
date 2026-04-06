<?php

namespace app\common;

use ReflectionClass;
use yii\db\Connection;
use yii\db\Query;

trait ReadMapperTrait
{
    abstract protected function getConnection(): Connection;
    abstract protected function tableName(): string;
    /**
     * Метод для гидрции сущности.
     * Для автоматической гидрации можно вызвать mapToEntity(string $prefix, array $array, $entityClass)
     * где $prefix это имя таблицы из которой берутся данные. $entityClass это класс сущности.
     * Можно вызывать несколько раз для заполнения из разных таблицы или в разные сущности.
     */
    abstract protected function arrayToEntity(array $array);
    /**
     * Возвращает массив в виде таблиц и соответствующих им столбцам.
     * При наличии join надо указать все участвующие таблицы
     * @return ['tableName' => ['column1', 'column2']]
     */
    abstract protected function selectColumns();

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

    /**
     * При join запросах переопределить данный метод и добавить в $query необходимый join
     */
    protected function withRelations(Query $query)
    {
        return $query;
    }

    protected function mapToEntity(string $prefix, array $array, $entityClass)
    {
        $reflection = new ReflectionClass($entityClass);
        $instance = $reflection->newInstanceWithoutConstructor();
        foreach($reflection->getProperties() as $property) {
            $type = $property->getType();
            if ($type && !$type->isBuiltin()) {
                continue;
            }
            $name = $property->name;
            $key = "$prefix-$name";
            if (!array_key_exists($key, $array)) {
                return null;
            }
            if (is_null($array[$key]) && !$type->allowsNull()) {
                return null;
            }
            $property->setValue($instance, $array[$key]);
        }
        return $instance;
    }

    private function select(Query $query)
    {
        $aliases = [];
        $tables = $this->selectColumns();
        foreach ($tables as $table => $columns) {
            foreach ($columns as $column) {
                $aliases[] = "$table.$column AS $table-$column";
            }
        }
        return $query->select($aliases);
    }

    private function find()
    {
        $query = new Query()->from($this->tableName());
        $query = $this->withRelations($query);
        $query = $this->select($query);
        return $query;
    }



}