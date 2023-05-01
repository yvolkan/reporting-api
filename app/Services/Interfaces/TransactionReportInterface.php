<?php

namespace App\Services\Interfaces;

use App\Models\TransactionReport;

interface TransactionReportInterface
{
    /**
     * @param array $data
     * @return bool
     */
    public function store(array $data): bool;

    /**
     * @param array $filters|null
     * @return \Illuminate\Database\Eloquent\Builder|mixed $transaction
     */
    public function getAll(?array $filters);
}