<?php

namespace App\Services\Repositories;

use App\Models\TransactionReport;
use App\Services\Interfaces\TransactionReportInterface;
use Exception;

class TransactionReportRepository implements TransactionReportInterface
{
    /**
     * @param array $data
     * 
     * @return bool
     */
    public function store(array $data): bool
    {
        $transactionReport = new TransactionReport;

        try {
            $transactionReport->create($data);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param array $filters|null
     * 
     * @return \Illuminate\Database\Eloquent\Builder|mixed $transaction
     */
    public function getAll(?array $filters)
    {
        $transaction = TransactionReport::query()
            ->selectRaw('currency, SUM(amount) as total, COUNT(*) as count')
            ->when(isset($filters['fromDate']), function ($query) use ($filters) {
                return $query->where('date', '>=', $filters['fromDate']);
            })
            ->when(isset($filters['toDate']), function ($query) use ($filters) {
                return $query->where('date', '<=', $filters['toDate']);
            })
            ->when(isset($filters['merchantId']), function ($query) use ($filters) {
                return $query->where('merchant_id', $filters['merchantId']);
            })
            ->when(isset($filters['acquirerId']), function ($query) use ($filters) {
                return $query->where('acquirer_id', $filters['acquirerId']);
            })
            ->groupBy('currency');

        return $transaction->get();
    }
}