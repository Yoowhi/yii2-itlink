<?php

namespace app\repositories;

use app\entities\Car;
use app\entities\Page;
use app\interfaces\CarRepositoryInterface;
use app\mappers\CarAndCarOptionReadDataMapper;
use app\mappers\CarWriteDataMapper;

class CarRepository implements CarRepositoryInterface
{
    public function __construct(
        private CarWriteDataMapper $carWriteDataMapper,
        private CarAndCarOptionReadDataMapper $carAndCarOptionReadDataMapper
    ) {}

    public function save($entity): Car
    {
        if (!empty($entity->id)) {
            $exists = $this->carWriteDataMapper->existsById($entity->id);
            return $exists 
                ? $this->carWriteDataMapper->update($entity)
                : $this->carWriteDataMapper->insert($entity);
        }
        return $this->carWriteDataMapper->insert($entity);
    }

    public function findOne($id): Car|null
    {
        return $this->carAndCarOptionReadDataMapper->findOneById($id);
    }

    public function findPage(int $page, int $limit): Page
    {
        $offset = ($page - 1) * $limit;
        $pageEntity = new Page();
        $pageEntity->data = $this->carAndCarOptionReadDataMapper->findSlice($offset, $limit);
        $pageEntity->currentPage = $page;
        $pageEntity->limit = $limit;
        $pageEntity->totalItems = $this->carAndCarOptionReadDataMapper->countAll();
        $pageEntity->totalPages = ceil($pageEntity->totalItems / $limit);
        return $pageEntity;
    }
}