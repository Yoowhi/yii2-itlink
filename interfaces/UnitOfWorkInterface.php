<?php

namespace app\interfaces;

interface UnitOfWorkInterface
{
    public function atomic(callable $func): bool;

    // в принципе их можно держать открытыми для более сложной логики в сервисах
    public function begin();
    public function apply();
    public function cancel();
}