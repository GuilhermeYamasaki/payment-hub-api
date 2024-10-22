<?php

namespace App\Services;

use App\Services\Interfaces\MailServiceInterface;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Log;

class MailService implements MailServiceInterface
{
    use FileTrait;

    /**
     * {@inheritDoc}
     */
    public function notifyBilling(object $debt): void
    {
        Log::debug('Notify user of billing', [
            'debt' => $debt,
        ]);
    }
}
