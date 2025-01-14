<?php

namespace App\Http\Traits;

use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;

trait StripePaymentTrait
{
/**
 * Constructor to initialize Stripe API with the secret key from the configuration.
 *
 * This constructor sets the secret Stripe API key to allow interaction with Stripe's services.
 */
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

/**
 * Creates a Stripe PaymentIntent for charging a customer.
 *
 * This function generates a payment intent to charge a customer using their Stripe account.
 * It sets up the amount, currency, description, application fee, and transfer destination.
 *
 * @param string $customerStripeId The Stripe customer ID to charge.
 * @param int $amount The amount to charge in the smallest currency unit (e.g., cents for USD).
 * @param string $description A description for the payment.
 * @param int $applicationFee The application fee for the charge (in smallest currency unit).
 * @param string $destination The Stripe account ID to receive the transferred funds.
 *
 * @return \Stripe\PaymentIntent Returns the created PaymentIntent object.
 */
    public function createStripeCharge($customerStripeId, $amount, $description, $applicationFee, $destination)
    {
        return PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd',
            'customer' => $customerStripeId,
            'description' => $description,
            'application_fee_amount' => 0,
            'transfer_data' => [
                'destination' => $destination,
            ],
            'payment_method_types' => ['card'],
        ]);
    }

/**
 * Confirms the payment intent for a customer to complete the payment process.
 *
 * This function retrieves a PaymentIntent using its ID and confirms it by providing the payment method ID.
 * This process is used to finalize the payment for a transaction.
 *
 * @param string $paymentIntentId The ID of the PaymentIntent to confirm.
 * @param string $paymentMethodId The ID of the payment method used to complete the payment.
 *
 * @return \Stripe\PaymentIntent Returns the confirmed PaymentIntent object.
 */
    public function confirmPaymentIntent($paymentIntentId, $paymentMethodId)
    {

        $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
        $paymentIntent->confirm([
            'payment_method' => $paymentMethodId,
        ]);

        return $paymentIntent;
    }

/**
 * Retrieves the default payment method for a given customer.
 *
 * This function retrieves the Stripe customer object using the customer ID,
 * and then gets the default payment method ID set for the customer.
 *
 * @param string $customerId The Stripe customer ID for which the default payment method is retrieved.
 *
 * @return string|null Returns the default payment method ID or null if none is found.
 */
    public function getCustomerDefaultPaymentMethodId($customerId)
    {

        // Retrieve the customer object
        $customer = Customer::retrieve($customerId);

        // Get the default payment method ID
        $defaultPaymentMethodId = $customer->invoice_settings->default_payment_method;

        return $defaultPaymentMethodId;
    }

/**
 * Checks if the attorney has sufficient funds for a transaction by creating a PaymentIntent.
 *
 * This function creates a PaymentIntent using the default payment method of the attorney and attempts to confirm the payment.
 * It checks if the funds are available by confirming the PaymentIntent, and returns a status based on the result.
 *
 * @param string $attorneyCustomerId The Stripe customer ID for the attorney.
 * @param float $yblFees The amount of fees to be checked for payment.
 *
 * @return array Returns an array with the payment status and relevant message.
 * - `payment_id` (string): The ID of the payment if successful.
 * - `message` (string): A message about the transaction status.
 * - `status` (string): 'success', 'failed', or 'error' based on the outcome.
 */
    public function checkAttorneyFunds($attorneyCustomerId, $yblFees)
    {
        try {
            // Retrieve the customer's default payment method
            $customer = Customer::retrieve($attorneyCustomerId);
            $defaultPaymentMethod = $customer->invoice_settings->default_payment_method;

            if (!$defaultPaymentMethod) {
                return [
                    'payment_id' => '',
                    'message' => 'No default payment method found for this customer.',
                    'status' => 'failed'
                ];
            }

            // Create a PaymentIntent with capture_method set to manual
            $paymentIntent = PaymentIntent::create([
                'amount' => $yblFees*100,
                'currency' => 'usd',
                'customer' => $attorneyCustomerId,
                'payment_method' => $defaultPaymentMethod,
                'payment_method_types' => ['card'],
                'capture_method' => 'manual', // Authorization only
            ]);

            // Confirm the PaymentIntent to check if funds are available
            $paymentIntent->confirm();

            // Check the status of the PaymentIntent
            if ($paymentIntent->status === 'requires_capture') {
                return [
                    'payment_id' => $paymentIntent->id,
                    'message' => 'TRUE',
                    'status' => 'success'
                ];
            } else {
                return [
                    'payment_id' => '',
                    'message' => 'Not enough funds or card declined.',
                    'status' => 'failed'
                ];
            }
        } catch (ApiErrorException $e) {
            return [
                'payment_id' => '',
                'message' => $e->getMessage(),
                'status' => 'error'
            ];
        } catch (\Throwable $th) {
            return [
                'payment_id' => '',
                'message' => $th->getMessage(),
                'status' => 'error'
            ];
        }
    }

}
