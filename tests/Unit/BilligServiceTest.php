<?php

namespace Tests\Unit;

use App\Jobs\ProcessCsvBillingJob;
use App\Services\Interfaces\BillingServiceInterface;
use App\Services\Interfaces\DebtServiceInterface;
use App\Services\Interfaces\MailServiceInterface;
use App\Services\Interfaces\PaymentSlipServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BilligServiceTest extends TestCase
{
    /**
     * @test
     */
    public function should_save_and_dispatch_job_process_file_success(): void
    {
        // Arrange
        Queue::fake();
        Storage::fake();

        $file = UploadedFile::fake()->create('input.csv');

        // Act
        resolve(BillingServiceInterface::class)->saveAndProcessFile($file);

        //Assert
        Queue::assertPushed(ProcessCsvBillingJob::class);
    }

    /**
     * @test
     */
    public function should_process_debt_and_pass_all_steps_success(): void
    {
        // Arrange
        $billingMock = [
            'debtID' => fake()->uuid(),
            'name' => fake()->name(),
            'governmentId' => fake()->randomNumber(1, 100000),
            'email' => fake()->unique()->safeEmail(),
            'debtAmount' => fake()->numberBetween(),
            'debtDueDate' => fake()->date(),
        ];

        $debtServiceMock = $this->mock(
            DebtServiceInterface::class,
            function ($mock) use ($billingMock) {
                $mock->shouldReceive('find')
                    ->with(data_get($billingMock, 'debtID'))
                    ->andReturn(null);

                $mock->shouldReceive('persist')
                    ->andReturn();
            }
        );

        $paymentSlipServiceMock = $this->mock(
            PaymentSlipServiceInterface::class,
            function ($mock) {
                $mock->shouldReceive('generateSlip')
                    ->andReturn();
            }
        );

        $mailServiceMock = $this->mock(
            MailServiceInterface::class,
            function ($mock) {
                $mock->shouldReceive('notifyBilling')
                    ->andReturn();
            }
        );

        // Act
        resolve(BillingServiceInterface::class)
            ->processDebt($billingMock);

        // Assert
        $debtServiceMock->shouldHaveReceived('find')
            ->once();

        $debtServiceMock->shouldHaveReceived('persist')
            ->times(3);

        $paymentSlipServiceMock->shouldHaveReceived('generateSlip')
            ->once();

        $mailServiceMock->shouldHaveReceived('notifyBilling')
            ->once();
    }
}
