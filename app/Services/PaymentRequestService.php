<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use App\Interfaces\BankRepositoryInterface;
use App\Interfaces\PaymentRequestRepositoryInterface;
use App\Models\Bank;
use App\Models\PaymentRequest;
use App\Models\File;
use App\Notifications\PaymentRequestPaid;
use App\Notifications\PaymentRequestRejected;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentRequestService
{
    public function __construct(
        public PaymentRequestRepositoryInterface $paymentRequestRepositoryInterface,
        public BankRepositoryInterface $bankRepositoryInterface
    ) {
    }

    public function getAll()
    {
        return $this->paymentRequestRepositoryInterface->getAll();
    }

    public function storePaymentRequest($request)
    {
        DB::beginTransaction();
        try {
            $file = $this->paymentRequestRepositoryInterface->storeAttachment($request);

            $paymentRequest = $this->paymentRequestRepositoryInterface->store($request, $file);

            DB::commit();
            return $paymentRequest;

        } catch (\Exception $e) {
            ApiResponse::rollback($e);
        }
    }

    public function changeStatus($request)
    {
        $paymentRequestIds = collect($request->input('payment_request_ids'));

        $updatedPaymentRequests = [];

        $paymentRequestIds->each(function ($id) use ($request, &$updatedPaymentRequests) {

            $paymentRequest = $this->paymentRequestRepositoryInterface->findByField('id', $id);

            DB::beginTransaction();
            try {
                $paymentRequest = $this->paymentRequestRepositoryInterface->updateStatusAndComments(
                    $request,
                    $paymentRequest
                );

                // Send an email to user who made the payment request
                if ($request->input('status') == 'rejected') {
                    // $paymentRequest
                    //     ->user
                    //     ->notify(new PaymentRequestRejected($paymentRequest));
                }

                DB::commit();
                $updatedPaymentRequests[] = $paymentRequest;

            } catch (\Exception $e) {
                ApiResponse::rollback($e);
            }
        });

        return $updatedPaymentRequests;
    }

    public function payPaymentRequests()
    {
        $paymentRequests = $this->paymentRequestRepositoryInterface->getApproved();

        $paidPaymentRequests = [];

        $paymentRequests->each(function ($paymentRequest) use (&$paidPaymentRequests) {
            // try {
            // $bank = $this
            //     ->bankRepositoryInterface
            //     ->findByField('sheba_prefix', substr($paymentRequest->sheba_number, 0, 2));

            // $response = Http::post($bank->api_endpoint, [
            //     'sheba_number' => $paymentRequest->sheba_number,
            //     'price' => $paymentRequest->price,
            // ]);

            // $response->throwIf($response->failed());

            $paidPaymentRequests[] = $this->paymentRequestRepositoryInterface->updateStatusToPaid($paymentRequest);

            // $paymentRequest
            //     ->user
            //     ->notify(new PaymentRequestPaid($paymentRequest));

            // } catch (\Exception $e) {
            //     Log::info($e);
            // }
        });

        return $paidPaymentRequests;
    }
}
