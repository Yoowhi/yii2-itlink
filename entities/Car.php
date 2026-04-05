<?php

namespace app\entities;
use app\entities\CarOption;

class Car
{
    public ?int $id;
    public string $title;
    public string $description;
    public float $price;
    public string $photo_url;
    public string $contacts;
    public string $created_at;
    public ?CarOption $options;
}