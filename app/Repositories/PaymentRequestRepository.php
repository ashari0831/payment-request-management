<?php

namespace App\Repositories;

use App\Interfaces\PaymentRequestRepositoryInterface;
use App\Models\PaymentRequest;
use App\Models\File;

class PaymentRequestRepository implements PaymentRequestRepositoryInterface
{
    public function getAll()
    {
        return PaymentRequest::with([
            'user',
            'paymentCategory',
        ])->get();
    }

    public function getApproved()
    {
        return PaymentRequest::approved()->get();
    }

    public function store($request, $file)
    {
        return PaymentRequest::create([
            'file_id' => $file->id,
            'payment_category_id' => $request->payment_category_id,
            'description' => $request->description,
            'price' => $request->price,
            'sheba_number' => $request->sheba_number,
            'user_id' => auth()->user()->id,
            'status' => 'pending',
        ]);
    }

    public function storeAttachment($request)
    {
        return File::create([
            'path' => $request->file('file')->store('payment_request_attachments'),
        ]);
    }

    public function findByField($field, $value)
    {
        return PaymentRequest::where($field, $value)
            ->with(['paymentCategory', 'user'])
            ->firstOrFail();
    }

    public function updateStatusAndComments($request, $paymentRequest)
    {
        return tap($paymentRequest, function ($paymentRequest) use ($request) {
            $paymentRequest->status = $request->input('status');

            if ($request->input('status') == 'rejected') {
                $comments = $paymentRequest->comments;

                $comments[] = $request->input('comment');

                $paymentRequest->comments = $comments;
            }

            $paymentRequest->save();
        });
    }

    public function updateStatusToPaid($paymentRequest)
    {
        return tap($paymentRequest, function ($paymentRequest) {
            $paymentRequest->update([
                'status' => 'paid',
            ]);
        });
    }
}
