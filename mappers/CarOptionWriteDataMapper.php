<?php

namespace app\mappers;

use app\common\DataMapper;
use app\common\WriteMapperTrait;
use app\entities\CarOption;
use yii\db\Connection;

class CarOptionWriteDataMapper extends DataMapper
{
    use WriteMapperTrait;

    public function __construct(
        private Connection $db
    ) {}

    protected function getConnection(): Connection
    {
        return $this->db;
    }

    protected function tableName(): string
    {
        return 'car_option';
    }

    /**
     * @param CarOption $entity
     */
    protected function entityToArray($entity): array
    {
        $array = [
            'car_id' => $entity->car_id,
            'brand' => $entity->brand,
            'model' => $entity->model,
            'year' => $entity->year,
            'body' => $entity->body,
            'mileage' => $entity->mileage
        ];
        if (!empty($entity->id)) {
            $array['id'] = $entity->id;
        }
        return $array;
    }
}