<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\TransactionReport;
use App\Services\Interfaces\TransactionReportInterface;
use Illuminate\Console\Command;

class TransactionReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:report {--date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculation of transaction report';

    /**
     * @var TransactionReportInterface
     */
    private $transactionReport;

    /**
     * Create a new command instance.
     * 
     * @param TransactionReportInterface $transactionReport
     *
     * @return void
     */
    public function __construct(TransactionReportInterface $transactionReport)
    {
        $this->transactionReport = $transactionReport;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = $this->option('date');

        Transaction::query()
            ->selectRaw('SUM(originalAmount) as amount, originalCurreny as currency, COUNT(*) as total, merchant_id, acquirer_id, DATE_FORMAT(created_at, "%Y-%m-%d") as date')
            ->when($date, function ($query) use ($date) {
                $query
                    ->whereDate('created_at', '<=', $date)
                    ->whereDate('created_at', '>=', $date);
            })
            ->groupBy('originalCurreny', 'merchant_id', 'acquirer_id')
            ->groupByRaw('DATE_FORMAT(created_at, "%Y-%m-%d")')
            ->chunk(10, function ($transactions) {
                foreach ($transactions as $transaction) {
                    $this->transactionReport->store([
                        'merchant_id' => $transaction->merchant_id,
                        'acquirer_id' => $transaction->acquirer_id, 
                        'amount' => $transaction->amount, 
                        'currency' => $transaction->currency,
                        'date' => $transaction->date,
                    ]);
                }
            });
    }
}
