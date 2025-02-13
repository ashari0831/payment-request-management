<?php

namespace App\Jobs;

use App\Services\PaymentRequestService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class PayApprovedPaymentRequests implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(PaymentRequestService $paymentRequestService): void
    {
        $paymentRequestService->payPaymentRequests();
    }
}
