<?php

namespace app\interfaces;

use app\entities\Car;
use app\entities\Page;

interface CarRepositoryInterface
{
    public function findOne($id): Car|null;
    public function save($entity): Car;
    public function findPage(int $page, int $limit): Page;
}