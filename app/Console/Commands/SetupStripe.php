<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\File;

class SetupStripe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a basic Stripe product and price, and save it to the .env file.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Initializing Stripe Setup...');

        try {
            $stripe = Cashier::stripe();

            // 1. Create a Product
            $this->info('Creating Stripe Product: "Basic Plan"...');
            $product = $stripe->products->create([
                'name' => 'Basic Plan',
                'description' => 'A basic subscription plan for all premium features.',
            ]);

            // 2. Create a Price for the Product (~$10/month)
            $this->info('Creating Stripe Price ($10.00/month)...');
            $price = $stripe->prices->create([
                'unit_amount' => 1000, // $10.00 in cents
                'currency' => 'usd',
                'recurring' => ['interval' => 'month'],
                'product' => $product->id,
            ]);

            $this->info("Successfully created Price ID: {$price->id}");

            // 3. Save to .env
            $this->info('Updating .env file with STRIPE_PRICE_ID_BASIC...');
            $envPath = base_path('.env');

            if (File::exists($envPath)) {
                $envContent = File::get($envPath);

                if (str_contains($envContent, 'STRIPE_PRICE_ID_BASIC=')) {
                    // Replace existing placeholder or value
                    $envContent = preg_replace('/STRIPE_PRICE_ID_BASIC=.*/', 'STRIPE_PRICE_ID_BASIC=' . $price->id, $envContent);
                } else {
                    // Append it nicely
                    $envContent .= "\nSTRIPE_PRICE_ID_BASIC={$price->id}\n";
                }

                File::put($envPath, $envContent);
                $this->info('✅ .env updated successfully.');
            } else {
                $this->warn('Could not find .env file. Please add manually: STRIPE_PRICE_ID_BASIC=' . $price->id);
            }

            $this->info('✅ Stripe setup complete! You are ready to accept subscriptions.');

        } catch (\Exception $e) {
            $this->error('Stripe Setup Failed: ' . $e->getMessage());
            $this->error('Please ensure your STRIPE_SECRET is set correctly in .env.');
        }
    }
}
