<?php

namespace app\dto;

readonly class CreateCarDto 
{
    public string $title;
    public string $description;
    public float $price;
    public string $photo_url;
    public string $contacts;
}