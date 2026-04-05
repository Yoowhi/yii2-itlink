<?php

namespace app\mappers;

use app\common\DataMapper;
use app\common\WriteMapperTrait;
use app\entities\Car;
use yii\db\Connection;

class CarWriteDataMapper extends DataMapper
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
        return 'car';
    }

    /**
     * @param Car $entity
     */
    protected function entityToArray($entity): array
    {
        $array = [
            'title' => $entity->title,
            'description' => $entity->description,
            'price' => $entity->price,
            'photo_url' => $entity->photo_url,
            'contacts' => $entity->contacts,
            'created_at' => $entity->created_at
        ];
        if (!empty($entity->id)) {
            $array['id'] = $entity->id;
        }
        return $array;
    }
}