<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProcessBillingControllerTest extends TestCase
{
    /**
     * @test
     */
    public function should_send_attachment_file_to_process_success(): void
    {
        // Arrange
        Queue::fake();
        Storage::fake();

        $file = UploadedFile::fake()->create('input.csv');

        // Act
        $response = $this->postJson(
            route('billing.process.csv'),
            [
                'attachment' => $file,
            ],
        );

        // Assert
        $response->assertOk();
    }

    /**
     * @test
     */
    public function should_error_when_send_empty_body(): void
    {
        // Arrange
        $body = [];

        // Act
        $response = $this->postJson(
            route('billing.process.csv'),
            $body
        );

        // Assert
        $response->assertUnprocessable();
    }
}
