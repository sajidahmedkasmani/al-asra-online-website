<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Notifications\CustomerPasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class CustomerAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_login_offers_password_recovery_and_google_sign_in(): void
    {
        $this->get(route('customer.login'))
            ->assertOk()
            ->assertSee(route('customer.password.request'))
            ->assertSee(route('customer.google.redirect'));
    }

    public function test_customer_can_request_a_password_reset_link(): void
    {
        Notification::fake();

        $customer = Customer::create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'password' => 'old-password',
        ]);

        $this->post(route('customer.password.email'), ['email' => $customer->email])
            ->assertRedirect()
            ->assertSessionHas('status', __(Password::RESET_LINK_SENT));

        Notification::assertSentTo($customer, CustomerPasswordReset::class);
    }

    public function test_customer_can_reset_their_password(): void
    {
        $customer = Customer::create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'password' => 'old-password',
        ]);
        $token = Password::broker('customers')->createToken($customer);

        $this->post(route('customer.password.update'), [
            'token' => $token,
            'email' => $customer->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ])->assertRedirect(route('customer.login'));

        $this->assertTrue(Hash::check('NewPassword123!', $customer->fresh()->password));
    }

    public function test_google_sign_in_reports_missing_configuration(): void
    {
        config([
            'services.google.client_id' => null,
            'services.google.client_secret' => null,
            'services.google.redirect' => null,
        ]);

        $this->get(route('customer.google.redirect'))
            ->assertRedirect(route('customer.login'))
            ->assertSessionHasErrors('google');
    }
}
