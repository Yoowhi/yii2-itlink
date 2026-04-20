<?php

namespace app\models;

use app\common\DtoModel;
use app\dto\CreateCarOptionDto;

/**
 * @extends DtoModel<CreateCarOptionDto>
 * @method CreateCarOptionDto toDto()
 */
class CreateCarOptionModel extends DtoModel
{
    public $brand;
    public $model;
    public $year;
    public $body;
    public $mileage;

    protected function dtoClass(): string
    {
        return CreateCarOptionDto::class;
    }

    public function rules()
    {
        return [
            [['brand', 'model', 'year', 'body', 'mileage'], 'required'],
            [['brand', 'model', 'body'], 'string'],
            [['brand', 'model', 'body'], 'filter', 'filter' => function ($val) { return strip_tags(trim($val)); }],
            [['year'], 'integer', 'min' => 0, 'max' => (int)date('Y')],
            [['mileage'], 'number', 'min' => 0]
        ];
    }
}