<?php

namespace app\repositories;

use app\entities\CarOption;
use app\interfaces\CarOptionRepositoryInterface;
use app\mappers\CarOptionWriteDataMapper;

class CarOptionRepository implements CarOptionRepositoryInterface
{
    public function __construct(
        private CarOptionWriteDataMapper $carOptionWriteDataMapper
    ) {}

    public function save(CarOption $entity): CarOption
    {
        if (!empty($entity->id)) {
            $exists = $this->carOptionWriteDataMapper->existsById($entity->id);
            return $exists 
                ? $this->carOptionWriteDataMapper->update($entity)
                : $this->carOptionWriteDataMapper->insert($entity);
        }
        return $this->carOptionWriteDataMapper->insert($entity);
    }
}