<?php

namespace app\dto;

readonly class CreateCarOptionDto 
{
    public string $brand;
    public string $model;
    public int $year;
    public string $body;
    public int $mileage;
}