<?php

namespace app\entities;

class CarOption 
{
    public ?int $id;
    public ?int $car_id;
    public string $brand;
    public string $model;
    public int $year;
    public string $body;
    public int $mileage;
}