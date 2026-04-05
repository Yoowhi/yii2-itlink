<?php

namespace app\entities;

class Page
{
    public array $data;
    public int $currentPage;
    public int $limit;
    public int $totalPages;
    public int $totalItems;
}