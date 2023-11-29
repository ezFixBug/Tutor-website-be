<?php

namespace App\Http\Controllers;

use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StripleController extends Controller
{

    public function setupIntents(Request $request, string $id)
    {
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_secret_key'));

        try {
            $customer = User::find($id);

            if ($customer->stripe_id) {
                $stripe_customer = $stripe->customers->retrieve($customer->stripe_id);
            } else {
                $stripe_customer = $stripe->customers->create([
                    'email' => $customer->email,
                    'name' => $customer->name,
                    'phone' => $customer->phone_number
                ]);

                // Update the customer's stripe_id in your database
                $customer->stripe_id = $stripe_customer->id;
                $customer->save();
            }

            $ephemeralKey = $stripe->ephemeralKeys->create([
                'customer' => $stripe_customer->id,
            ], [
                'stripe_version' => '2022-08-01',
            ]);

            $payment_intent = $stripe->setupIntents->create([
                'customer' => $stripe_customer->id,
                'payment_method_types' => ['card'],
            ]);

            $response = [
                'client_secret' => $payment_intent->client_secret,
                'ephemeral_key' => $ephemeralKey->secret,
                'customer' => $stripe_customer->id,
                'publishable_key' => config('stripe.stripe_public_key'),
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    // Get credit card information registered with Stripe [get]
    public function getPaymentMethods(Request $request, string $id)
    {
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_secret_key'));

        try {
            $customer = User::find($id);

            if (!$customer->stripe_id) {
                return response()->json([]);
            }

            $payment_methods = $stripe->paymentMethods->all([
                'customer' => $customer->stripe_id,
                'type' => 'card',
            ]);

            $response = [
                'payment_methods' => $payment_methods->data,
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function paymentIntents(Request $request, string $id)
    {
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_secret_key'));

        DB::beginTransaction();
        try {
            $customer = User::find($id);
            if ($customer->stripe_id) {
                $stripe_customer = $stripe->customers->retrieve($customer->stripe_id);
            } else {
                $stripe_customer = $stripe->customers->create([
                    'email' => $customer->email,
                    'name' => $customer->name,
                    'phone' => $customer->phone_number
                ]);

                $customer->stripe_id = $stripe_customer->id;
                $customer->save();
            }

            if (!is_null($request->payment_method)) {
                $payment_intent = $stripe->paymentIntents->create([
                    'amount' => $request->amount,
                    'currency' => 'jpy',
                    'customer' => $stripe_customer->id,
                    'payment_method' => $request->payment_method['id'],
                ]);
            } else {
                $payment_intent = $stripe->paymentIntents->create([
                    'amount' => $request->amount,
                    'currency' => 'jpy',
                    'customer' => $stripe_customer->id,
                    'payment_method_types' => ['card'],
                ]);
            }

            $response = [
                'client_secret' => $payment_intent->client_secret,
            ];

            DB::commit();
            return response()->json($response);
        } catch (\Stripe\Exception\CardException $e) {
            $payment_intent_id = $e->getError()->payment_intent->id;
            $payment_intent = $stripe->paymentIntents->retrieve($payment_intent_id);
            $response = [
                'payment_intent' => $payment_intent,
            ];
            DB::rollBack();
            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e);
        }
    }

    public function updatePaymentIntents(Request $request, string $id)
    {
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_secret_key'));

        DB::beginTransaction();
        try {
            $customer = User::find($id);
            if ($customer->stripe_id) {
                $stripe_customer = $stripe->customers->retrieve($customer->stripe_id);
            } else {
                $stripe_customer = $stripe->customers->create([
                    'email' => $customer->email,
                    'name' => $customer->name,
                    'phone' => $customer->phone_number
                ]);

                $customer->stripe_id = $stripe_customer->id;
                $customer->save();
            }

            $payment_intent = $stripe->paymentIntents->update($request->payment_intent_id, [
                'payment_method' => $request->payment_method_id,
            ]);

            $response = [
                'client_secret' => $payment_intent->client_secret,
            ];

            DB::commit();
            return response()->json($response);
        } catch (\Stripe\Exception\CardException $e) {
            $payment_intent_id = $e->getError()->payment_intent->id;
            $payment_intent = $stripe->paymentIntents->retrieve($payment_intent_id);
            $response = [
                'payment_intent' => $payment_intent,
            ];
            DB::rollBack();
            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e);
        }
    }
}
