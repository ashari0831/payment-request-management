<?php

namespace App\Interfaces;

interface PaymentRequestRepositoryInterface
{
    public function getAll();

    public function getApproved();

    public function store($request, $file);

    public function storeAttachment($request);

    public function findByField($field, $value);

    public function updateStatusAndComments($request, $paymentRequest);

    public function updateStatusToPaid($paymentRequest);
}
