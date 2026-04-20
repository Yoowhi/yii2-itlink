<?php

namespace app\common;

use app\interfaces\UnitOfWorkInterface;
use yii\base\Exception;
use yii\db\Connection;
use yii\db\Transaction;

class DbUnitOfWork implements UnitOfWorkInterface
{
    private Transaction|null $transaction = null;

    public function __construct(
        private Connection $db
    ) {}

    public function begin()
    {
        if (!is_null($this->transaction)) {
            throw new Exception('Another transaction is already in progress');
        }
        $this->transaction = $this->db->beginTransaction();
    }

    public function apply()
    {
        if (is_null($this->transaction)) {
            throw new Exception('There is no transaction in progress. You should use begin() before doing this');
        }
        $this->transaction->commit();
    }

    public function cancel()
    {
        if (is_null($this->transaction)) {
            throw new Exception('There is no transaction in progress. You should use begin() before doing this');
        }
        $this->transaction->rollBack();
    }

    public function atomic(callable $func): bool
    {
        try {
            $this->begin();
            $func();
            $this->apply();
            return true;
        } catch (Exception $ex) {
            $this->cancel();
            return false;
        }
    }
}