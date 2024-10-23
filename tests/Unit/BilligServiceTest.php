<?php

namespace Tests\Unit;

use App\Repositories\Interfaces\DebtRepositoryInterface;
use App\Services\Interfaces\BillingServiceInterface;
use Illuminate\Support\Facades\Queue;
use InvalidArgumentException;
use Tests\TestCase;

class BilligServiceTest extends TestCase
{
    public function test_process_debt_to_insert_database_and_dispatch_jobs(): void
    {
        // Arrange
        Queue::fake();

        $billingMock = [
            'debtId' => fake()->uuid(),
            'name' => fake()->name(),
            'governmentId' => fake()->randomNumber(1, 100000),
            'email' => fake()->unique()->safeEmail(),
            'debtAmount' => fake()->numerify('###.##'),
            'debtDueDate' => fake()->date(),
        ];

        $debtRepositoryMock = $this->mock(
            DebtRepositoryInterface::class,
            function ($mock) {
                $mock->shouldReceive('insert')
                    ->andReturn();
            }
        );

        // Act
        resolve(BillingServiceInterface::class)
            ->processDebts(collect([$billingMock]));

        // Assert
        $debtRepositoryMock->shouldHaveReceived('insert')
            ->once();
    }

    public function test_error_when_process_debt_with_invalid_data(): void
    {
        // Assert
        $this->expectException(InvalidArgumentException::class);

        // Arrange
        $billingMock = [
            'test',
        ];

        // Act
        resolve(BillingServiceInterface::class)
            ->processDebts(collect([$billingMock]));

    }
}
