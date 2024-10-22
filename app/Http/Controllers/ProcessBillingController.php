<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessBillingRequest;
use App\Services\Interfaces\BillingServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessBillingController extends Controller
{
    public function __construct(
        private readonly BillingServiceInterface $billingService
    ) {}

    public function __invoke(ProcessBillingRequest $request): JsonResponse
    {
        try {
            $this->billingService->saveAndProcessFile(
                $request->file('attachment')
            );

            return response()->json(
                status: JsonResponse::HTTP_OK
            );
        } catch (Throwable $exception) {
            Log::critical(self::class, [
                'message' => 'proccess_billing_controller_error',
                'exception' => $exception,
            ]);

            return response()->json(
                status: JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
