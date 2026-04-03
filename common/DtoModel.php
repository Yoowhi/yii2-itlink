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
    public function toDto(): object
    {
        $class = $this->dtoClass();
        $reflection = new ReflectionClass($class);
        $instance = $reflection->newInstanceWithoutConstructor();

        foreach ($reflection->getProperties() as $prop) {
            $name = $prop->getName();
            if (!property_exists($this, $name)) {
                throw new Exception("Class " . $this->class . " doesn't have a property with name: $name");
            }
            $prop->setValue($instance, $this->$name);
        }
        return $instance;
    }
}