<?php

namespace app\common;

use yii\db\Connection;

abstract class DataMapper
{
    protected abstract function getConnection(): Connection;
    protected abstract function tableName(): string;    
}