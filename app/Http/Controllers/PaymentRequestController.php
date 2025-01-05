<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\ChangePaymentStatusRequest;
use App\Http\Requests\DownloadFileRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentRequestResource;
use App\Services\PaymentRequestService;
use App\Models\File;

class PaymentRequestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/payment-requests",
     *     summary="List payment requests",
     *     tags={"Payment Requests"},
     * @OA\Response(
     *     response=200,
     *     description="Successful response",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="success",
     *             type="boolean",
     *             example=true
     *         ),
     *         @OA\Property(
     *             property="data",
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="9de57955-998d-4345-ac43-405d145896b1"),
     *                 @OA\Property(property="status", type="string", example="pending"),
     *                 @OA\Property(property="file_id", type="string", example="9de57955-839c-4d20-bbaa-181fce9efa96"),
     *                 @OA\Property(
     *                     property="payment_category",
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="9de1a27b-c068-4611-96fd-9bd9fd1f7a3c"),
     *                     @OA\Property(property="title", type="string", example="حمل و نقل"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-03T17:09:52.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-03T17:09:52.000000Z")
     *                 ),
     *                 @OA\Property(property="description", type="string", example="desc"),
     *                 @OA\Property(property="price", type="integer", example=12000),
     *                 @OA\Property(property="sheba_number", type="string", example="123456789123456789123456"),
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="9de19ee8-58d7-4998-96c2-e12a4eaea912"),
     *                     @OA\Property(property="name", type="string", example="user"),
     *                     @OA\Property(property="email", type="string", example="user@test.com"),
     *                     @OA\Property(property="national_code", type="string", example="1123456789"),
     *                     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, example=null),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-03T16:59:52.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-03T16:59:52.000000Z")
     *                 ),
     *                 @OA\Property(property="comments", type="string", nullable=true, example=null),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-05T14:58:07.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-05T14:58:07.000000Z")
     *             )
     *         )
     *     )
     * ),
     *     @OA\Header(
     *         header="Accept",
     *         description="Accept header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="application/json"
     *         )
     *     ),
     *     @OA\Header(
     *         header="Authorization",
     *         description="Authorization header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer {token}"
     *         )
     *     )
     * )
     */
    public function index(PaymentRequestService $paymentRequestService)
    {
        $paymentRequests = $paymentRequestService->getAll();

        return ApiResponse::sendResponse(PaymentRequestResource::collection($paymentRequests));
    }

    /**
     * @OA\Post(
     *     path="/api/payment-requests",
     *     summary="Create a new payment request",
     *     tags={"Payment Requests"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="payment_category_id",
     *                 type="string",
     *                 format="uuid",
     *                 example="9de1a27b-c068-4611-96fd-9bd9fd1f7a3c",
     *                 description="ID of the payment category"
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 nullable=true,
     *                 example="desc",
     *                 description="Description of the payment request"
     *             ),
     *             @OA\Property(
     *                 property="price",
     *                 type="integer",
     *                 example=12000,
     *                 description="Price of the payment request"
     *             ),
     *             @OA\Property(
     *                 property="file",
     *                 type="string",
     *                 format="binary",
     *                 description="File attachment for the payment request"
     *             ),
     *             @OA\Property(
     *                 property="sheba_number",
     *                 type="string",
     *                 example="123456789123456789123456",
     *                 description="Sheba number for the payment request"
     *             ),
     *             @OA\Property(
     *                 property="national_code",
     *                 type="string",
     *                 example="1123456789",
     *                 description="National code of the user"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment Request Create Successful",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="9de57955-998d-4345-ac43-405d145896b1"),
     *                 @OA\Property(property="status", type="string", example="pending"),
     *                 @OA\Property(property="file_id", type="string", example="9de57955-839c-4d20-bbaa-181fce9efa96"),
     *                 @OA\Property(
     *                     property="payment_category",
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="9de1a27b-c068-4611-96fd-9bd9fd1f7a3c"),
     *                     @OA\Property(property="title", type="string", example="حمل و نقل"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-03T17:09:52.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-03T17:09:52.000000Z")
     *                 ),
     *                 @OA\Property(property="description", type="string", example="desc"),
     *                 @OA\Property(property="price", type="integer", example=12000),
     *                 @OA\Property(property="sheba_number", type="string", example="123456789123456789123456"),
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="9de19ee8-58d7-4998-96c2-e12a4eaea912"),
     *                     @OA\Property(property="name", type="string", example="user"),
     *                     @OA\Property(property="email", type="string", example="user@test.com"),
     *                     @OA\Property(property="national_code", type="string", example="1123456789"),
     *                     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, example=null),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-03T16:59:52.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-03T16:59:52.000000Z")
     *                 ),
     *                 @OA\Property(property="comments", type="string", nullable=true, example=null),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-05T14:58:07.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-05T14:58:07.000000Z")
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Payment Request Create Successful"
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="application/json"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer {token}"
     *         )
     *     )
     * )
     */
    public function store(StorePaymentRequest $request, PaymentRequestService $paymentRequestService)
    {
        $paymentRequest = $paymentRequestService->storePaymentRequest($request);

        return ApiResponse::sendResponse(new PaymentRequestResource($paymentRequest), 'Payment Request Create Successful');
    }

    /**
     * @OA\Post(
     *     path="/api/payment-requests/change-status",
     *     summary="Change payment requests status",
     *     tags={"Payment Requests"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="payment_request_ids",
     *                 type="array",
     *                 @OA\Items(
     *                     type="string",
     *                     format="uuid",
     *                     example="9de1f353-4208-4620-901a-dc1a5978c374"
     *                 ),
     *                 description="Array of payment request IDs"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="rejected",
     *                 description="Status of the payment request",
     *                 enum={"approved", "rejected"}
     *             ),
     *             @OA\Property(
     *                 property="comment",
     *                 type="string",
     *                 nullable=true,
     *                 example="Rejection related comment",
     *                 description="Optional comment about the payment request"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment Requests Pay Successful",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="9de57955-998d-4345-ac43-405d145896b1"),
     *                     @OA\Property(property="status", type="string", example="rejected"),
     *                     @OA\Property(property="file_id", type="string", example="9de57955-839c-4d20-bbaa-181fce9efa96"),
     *                     @OA\Property(
     *                         property="payment_category",
     *                         type="object",
     *                         @OA\Property(property="id", type="string", example="9de1a27b-c068-4611-96fd-9bd9fd1f7a3c"),
     *                         @OA\Property(property="title", type="string", example="حمل و نقل"),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-03T17:09:52.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-03T17:09:52.000000Z")
     *                     ),
     *                     @OA\Property(property="description", type="string", example="desc"),
     *                     @OA\Property(property="price", type="integer", example=12000),
     *                     @OA\Property(property="sheba_number", type="string", example="123456789123456789123456"),
     *                     @OA\Property(
     *                         property="user",
     *                         type="object",
     *                         @OA\Property(property="id", type="string", example="9de19ee8-58d7-4998-96c2-e12a4eaea912"),
     *                         @OA\Property(property="name", type="string", example="user"),
     *                         @OA\Property(property="email", type="string", example="user@test.com"),
     *                         @OA\Property(property="national_code", type="string", example="1123456789"),
     *                         @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, example=null),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-03T16:59:52.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-03T16:59:52.000000Z")
     *                     ),
     *                     @OA\Property(
     *                         property="comments",
     *                         type="array",
     *                         @OA\Items(
     *                             type="string",
     *                             example="Rejection related comment"
     *                         ),
     *                         nullable=true
     *                     ),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-05T14:58:07.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-05T14:58:07.000000Z")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Payment Requests Pay Successful"
     *             )
     *         )
     *     ),
     *     @OA\Header(
     *         header="Accept",
     *         description="Accept header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="application/json"
     *         )
     *     ),
     *     @OA\Header(
     *         header="Authorization",
     *         description="Authorization header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer {token}"
     *         )
     *     )
     * )
     */
    public function changeStatus(ChangePaymentStatusRequest $request, PaymentRequestService $paymentRequestService)
    {
        $paymentRequests = $paymentRequestService->changeStatus($request);

        return ApiResponse::sendResponse(PaymentRequestResource::collection($paymentRequests), 'Payment Requests Change Status Successful');
    }

    /**
     * @OA\Get(
     *     path="/api/files/{file}/download",
     *     summary="Download payment request attachment file",
     *     tags={"Payment Requests"},
     *     @OA\Parameter(
     *         name="file",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="9de1f353-4208-4620-901a-dc1a5978c374"
     *         ),
     *         description="File ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="File downloaded successfully",
     *         @OA\Header(
     *             header="Content-Disposition",
     *             description="attachment; filename={filename}",
     *             @OA\Schema(
     *                 type="string"
     *             )
     *         ),
     *     ),
     *     @OA\Header(
     *         header="Accept",
     *         description="Accept header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="application/json"
     *         )
     *     ),
     *     @OA\Header(
     *         header="Authorization",
     *         description="Authorization header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer {token}"
     *         )
     *     )
     * )
     */
    public function downloadAttachment(File $file)
    {
        return response()->download(storage_path('app/private/' . $file->path));
    }

    /**
     * @OA\Post(
     *     path="/api/payment-requests/pay",
     *     summary="Pay approved payment requests",
     *     tags={"Payment Requests"},
     *     @OA\Response(
     *         response=200,
     *         description="Payment Requests Pay Successful",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="string", example="9de523d2-b3d9-4b67-9a66-fc2c9ab31ac9"),
     *                     @OA\Property(property="status", type="string", example="paid"),
     *                     @OA\Property(property="file_id", type="string", example="9de523d2-a8ee-42ce-94d8-81c1a15f52b7"),
     *                     @OA\Property(
     *                         property="payment_category",
     *                         type="object",
     *                         @OA\Property(property="id", type="string", example="9de1a27b-c068-4611-96fd-9bd9fd1f7a3c"),
     *                         @OA\Property(property="title", type="string", example="حمل و نقل"),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-03T17:09:52.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-03T17:09:52.000000Z")
     *                     ),
     *                     @OA\Property(property="description", type="string", example="desc"),
     *                     @OA\Property(property="price", type="integer", example=12000),
     *                     @OA\Property(property="sheba_number", type="string", example="123456789123456789123456"),
     *                     @OA\Property(
     *                         property="user",
     *                         type="object",
     *                         @OA\Property(property="id", type="string", example="9de19ee8-58d7-4998-96c2-e12a4eaea912"),
     *                         @OA\Property(property="name", type="string", example="user"),
     *                         @OA\Property(property="email", type="string", example="user@test.com"),
     *                         @OA\Property(property="national_code", type="string", example="1123456789"),
     *                         @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, example=null),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-03T16:59:52.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-03T16:59:52.000000Z")
     *                     ),
     *                     @OA\Property(property="comments", type="string", nullable=true, example=null),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-05T10:59:00.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-05T14:32:47.000000Z")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Payment Requests Pay Successful"
     *             )
     *         )
     *     ),
     *     @OA\Header(
     *         header="Accept",
     *         description="Accept header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="application/json"
     *         )
     *     ),
     *     @OA\Header(
     *         header="Authorization",
     *         description="Authorization header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer {token}"
     *         )
     *     )
     * )
     */
    public function payPaymentRequests(PaymentRequestService $paymentRequestService)
    {
        $paidPaymentRequests = $paymentRequestService->payPaymentRequests();

        return ApiResponse::sendResponse(PaymentRequestResource::collection($paidPaymentRequests), 'Payment Requests Pay Successful');
    }
}
