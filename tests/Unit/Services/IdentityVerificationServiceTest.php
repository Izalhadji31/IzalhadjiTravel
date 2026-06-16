<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\IdentityVerificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class IdentityVerificationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(IdentityVerificationService::class);
    }

    public function test_can_create_identity_verification()
    {
        $user = User::factory()->create();

        $data = [
            'full_name' => 'John Doe',
            'id_type' => 'KTP',
            'id_number' => '1234567890123456',
            'id_expiry_date' => now()->addYears(5),
        ];

        $verification = $this->service->createOrUpdate($user, $data);

        $this->assertNotNull($verification);
        $this->assertEquals('John Doe', $verification->full_name);
        $this->assertEquals('KTP', $verification->id_type);
    }

    public function test_can_verify_identity()
    {
        $user = User::factory()->create();
        $verification = $user->identityVerification()->create([
            'full_name' => 'John Doe',
            'id_type' => 'KTP',
            'id_number' => '1234567890123456',
        ]);

        $this->service->approveVerification($verification, $user->id);

        $verification->refresh();
        $this->assertTrue($verification->is_verified);
        $this->assertNotNull($verification->verified_at);
    }

    public function test_can_reject_identity()
    {
        $user = User::factory()->create();
        $verification = $user->identityVerification()->create([
            'full_name' => 'John Doe',
            'id_type' => 'KTP',
            'id_number' => '1234567890123456',
        ]);

        $this->service->rejectVerification($verification, 'ID not clear');

        $verification->refresh();
        $this->assertFalse($verification->is_verified);
        $this->assertEquals('ID not clear', $verification->rejection_reason);
    }

    public function test_can_get_verification_status()
    {
        $user = User::factory()->create();
        $verification = $user->identityVerification()->create([
            'full_name' => 'John Doe',
            'id_type' => 'KTP',
            'id_number' => '1234567890123456',
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        $status = $this->service->getStatus($user);

        $this->assertEquals('verified', $status['status']);
        $this->assertNotNull($status['verified_at']);
    }

    public function test_can_get_pending_verifications()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $user1->identityVerification()->create([
            'full_name' => 'User 1',
            'id_type' => 'KTP',
            'id_number' => '1111111111111111',
        ]);

        $user2->identityVerification()->create([
            'full_name' => 'User 2',
            'id_type' => 'SIM',
            'id_number' => '2222222222222222',
            'is_verified' => true,
        ]);

        $pending = $this->service->getPendingVerifications();

        $this->assertEquals(1, $pending->total());
    }
}
