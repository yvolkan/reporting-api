<?php

namespace App\Services\Repositories;

use App\Models\Transaction;
use App\Services\Interfaces\TransactionInterface;

class TransactionRepository implements TransactionInterface
{
    /**
     * @param array $filters|null
     * 
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder
     */
    public function getAll(?array $filters)
    {
        $transaction = Transaction::query()
            ->when(isset($filters['filterField']) && $filters['filterField'] == 'Transaction UUID', function ($query) use ($filters) {
                return $query->where('transaction_id', $filters['filterValue']);
            })
            ->when(isset($filters['filterField']) && $filters['filterField'] == 'Customer Email', function ($query) use ($filters) {
                return $query->whereHas('client', function ($query) use ($filters) {
                    $query->where('email', $filters['filterValue']);
                });
            })
            ->when(isset($filters['filterField']) && $filters['filterField'] == 'Card PAN', function ($query) use ($filters) {
                return $query->whereHas('card', function ($query) use ($filters) {
                    $query->where('number', 'like', '%' . $filters['filterValue'] . '%');
                });
            })
            ->when(isset($filters['fromDate']), function ($query) use ($filters) {
                return $query->where('created_at', '>=', $filters['fromDate']);
            })
            ->when(isset($filters['toDate']), function ($query) use ($filters) {
                return $query->where('created_at', '<=', $filters['toDate']);
            })
            ->when(isset($filters['merchantId']), function ($query) use ($filters) {
                return $query->where('merchant_id', $filters['merchantId']);
            })
            ->when(isset($filters['paymentMethod']), function ($query) use ($filters) {
                return $query->whereHas('acquirer', function ($query) use ($filters) {
                    $query->where('type', $filters['paymentMethod']);
                });
            })
            ->when(isset($filters['status']) || isset($filters['operation']) || isset($filters['errorCode']) || (isset($filters['filterField']) && in_array($filters['filterField'], ['Reference No', 'Custom Data'])), function ($query) use ($filters) {
                return $query->whereHas('merchantTransaction', function ($query) use ($filters) {
                    $query->when(isset($filters['status']), function ($query) use ($filters) {
                        $query->where('status', $filters['status']);
                    });
                    
                    $query->when(isset($filters['operation']), function ($query) use ($filters) {
                        $query->where('operation', $filters['operation']);
                    });
                    
                    $query->when(isset($filters['errorCode']), function ($query) use ($filters) {
                        $query->where('errorCode', $filters['errorCode']);
                    });
                    
                    $query->when(isset($filters['filterField']), function ($query) use ($filters) {
                        if ($filters['filterField'] == 'Reference No') {
                            $query->where('referenceNo', 'like', '%' . $filters['filterValue'] . '%');
                        } elseif ($filters['filterField'] == 'Custom Data') {
                            $query->where('customData', 'like', '%' . $filters['filterValue'] . '%');
                        }
                    });
                });
            });

        if (isset($filters['paginate'])) {
            $transaction = $transaction->paginate();
        }

        return $transaction;
    }

    /**
     * @param string $id
     * @return Transaction|null
     */
    public function byTransactionId(string $id): ?Transaction
    {
        return Transaction::where('transaction_id', $id)->first();
    }

    /**
     * @param string $id
     * @return Transaction|null
     */
    public function getClientByTransactionId(string $id): ?Transaction
    {
        return Transaction::where('transaction_id', $id)->first();
    }
}