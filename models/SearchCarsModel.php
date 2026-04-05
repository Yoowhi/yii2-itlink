<?php

namespace app\models;

use app\common\DtoModel;
use app\dto\SearchCarsDto;

/**
 * @method  toDto(): SearchCarsDto
 */
class SearchCarsModel extends DtoModel
{
    public $page = 1;
    public $limit = 10;

    protected function dtoClass(): string
    {
        return SearchCarsDto::class;
    }

    public function rules() {
        return [
            [['page', 'limit'], 'integer', 'min' => 1],
            [['limit'], 'integer', 'max' => 50],
        ];
    }
}