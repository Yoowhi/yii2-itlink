<?php

namespace app\models;

use app\common\DtoModel;
use app\dto\CreateCarDto;

/**
 * @extends DtoModel<CreateCarDto>
 * @method CreateCarDto toDto()
 */
class CreateCarModel extends DtoModel
{
    public $title;
    public $description;
    public $price;
    public $photo_url;
    public $contacts;

    protected function dtoClass(): string
    {
        return CreateCarDto::class;
    }

    public function rules()
    {
        return [
            [['title', 'description', 'price', 'photo_url', 'contacts'], 'required'],
            [['title', 'description', 'photo_url', 'contacts'], 'string'],
            [['title', 'description', 'photo_url', 'contacts'], 'filter', 'filter' => function ($val) { return strip_tags(trim($val)); }],
            [['price'], 'number', 'min' => 0]
        ];
    }
}