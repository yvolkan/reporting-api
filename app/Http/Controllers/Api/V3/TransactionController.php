<?php

namespace App\Http\Controllers\Api\V3;

use App\Enums\HttpStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Requests\TransactionReportRequest;
use App\Http\Resources\TransactionClientResource;
use App\Http\Resources\TransactionReportResource;
use App\Http\Resources\TransactionResource;
use App\Services\Interfaces\TransactionInterface;
use App\Services\Interfaces\TransactionReportInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    /**
     * @var TransactionInterface
     */
    private $transaction;

    /**
     * @var TransactionReportInterface
     */
    private $transactionReport;

    /**
     * @param TransactionInterface $transaction
     * @param TransactionReportInterface $transactionReport
     */
    public function __construct(TransactionInterface $transaction, TransactionReportInterface $transactionReport)
    {
        $this->transaction = $transaction;
        $this->transactionReport = $transactionReport;
    }

    /**
     * Request for report of transaction.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function report(Request $request) 
    {
        $filters = [];

        $filters = $request->only('fromDate', 'toDate', 'merchantId', 'acquirerId');

        return response()->json(
            TransactionReportResource::collection(
                $this->transactionReport->getAll($filters)
            )
        );
    }

    /**
     * Request for detail of transaction.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(TransactionRequest $request)
    {
        $transaction = $this->transaction->byTransactionId($request->input('transactionId'));

        if (! $transaction) {
            return response()->json([
                'status' => HttpStatusEnum::STATUS_FAIL,
                'message' => 'Transaction not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json(
            new TransactionResource($transaction)
        );
    }

    /**
     * Request for list of transactions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $filters = [
            'paginate' => true,
        ];

        $filters = array_merge($filters, 
            $request->only(
                'fromDate', 'toDate', 'status', 'operation', 'merchantId', 
                'paymentMethod', 'errorCode', 'filterField', 'filterValue'
            )
        );

        return response()->json(
            TransactionResource::collection(
                $this->transaction->getAll($filters)
            )->response()->getData(true)
        );
    }
    
    /**
     * Request for client of transaction.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function client(TransactionRequest $request)
    {
        $transaction = $this->transaction->getClientByTransactionId($request->input('transactionId'));

        if (! $transaction) {
            return response()->json([
                'status' => HttpStatusEnum::STATUS_FAIL,
                'message' => 'Transaction not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'customerInfo' => new TransactionClientResource($transaction), 
        ]);
    }
}
