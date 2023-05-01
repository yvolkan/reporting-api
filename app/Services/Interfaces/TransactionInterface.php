<?php

namespace App\Services\Interfaces;

use App\Models\Transaction;

interface TransactionInterface
{
    /**
     * @param array $filters|null
     * @return Transaction[]|null
     */
    public function getAll(?array $filters);

    /**
     * @param string $id
     * @return Transaction|null
     */
    public function byTransactionId(string $id): ?Transaction;

    /**
     * @param string $id
     * @return Transaction|null
     */
    public function getClientByTransactionId(string $id): ?Transaction;
}