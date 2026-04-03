<?php

namespace app\common;

use ReflectionClass;
use yii\base\Exception;
use yii\base\Model;


/**
 * Абстрактный родительский класс для всех моделей. 
 * Позволяет трансформировать модели в указанный DTO класс (после валидации), чтобы отвязать Yii2 от сервисов.
 * Признаюсь, фишки с рефлексией и дженериками в PHPDoc я подсмотрел, они мне понравились.
 * 
 * @template T of object
 */
abstract class DtoModel extends Model 
{
    /**
     * @return class-string<T>
     */
    abstract protected function dtoClass(): string;

    /**
     * @return T
     */
    public function toDto()
    {
        $class = $this->dtoClass();
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        if (!$constructor) {
            throw new Exception("Class $class doesn't have a constructor");
        }
        $args = [];
        foreach ($constructor->getParameters() as $param) {
            $name = $param->getName();
            $value = $this->$name ?? null;
            $args[$name] = $value;
        }
        return $reflection->newInstanceArgs($args);
    }
}