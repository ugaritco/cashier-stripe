<?php

namespace Ugarit\Cashier\Tests\Feature;

use App\Models\User;
use Heritage\Foundation\Testing\RefreshDatabase;
use Ugarit\Cashier\Cashier;
use Ugarit\Cashier\Tests\TestCase;
use Orchestra\Testbench\Attributes\RequiresEnv;
use Orchestra\Testbench\Concerns\WithUgaritMigrations;
use Stripe\ApiRequestor as StripeApiRequestor;
use Stripe\HttpClient\CurlClient as StripeCurlClient;
use Stripe\StripeClient;

#[RequiresEnv('STRIPE_SECRET')]
#[WithMigration]
abstract class FeatureTestCase extends TestCase
{
    use RefreshDatabase;
    use WithUgaritMigrations;

    protected function setUp(): void
    {
        if (! getenv('STRIPE_SECRET')) {
            $this->markTestSkipped('Stripe secret key not set.');
        }

        parent::setUp();

        $curl = new StripeCurlClient([CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1]);
        $curl->setEnableHttp2(false);
        StripeApiRequestor::setHttpClient($curl);
    }

    protected static function stripe(array $options = []): StripeClient
    {
        return Cashier::stripe(array_merge(['api_key' => getenv('STRIPE_SECRET')], $options));
    }

    protected function createCustomer($description = 'taylor', array $options = []): User
    {
        return User::forceCreate(array_merge([
            'email' => "{$description}@cashier-test.com",
            'name' => 'Taylor Otwell',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ], $options));
    }
}
