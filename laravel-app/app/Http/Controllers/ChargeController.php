<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Yoco\YocoClient;
use Yoco\Exceptions\ApiKeyException;
use Yoco\Exceptions\DeclinedException;
use Yoco\Exceptions\InternalException;

class ChargeController extends Controller
{

    public function charge()
    {
        $this->validate(request(), [
            'token' => 'required',
            'amountInCents' => 'required|int',
            'currency' => 'required'
        ]);

        $token = request()->input('token');
        $amountInCents = request()->input('amountInCents');
        $currency = request()->input('currency');
        $metadata = request()->input('metadata') ?? [];

        $client = new YocoClient(config('yoco.secret_key'), config('yoco.public_key'));

        // note the keys in use
        $env = $client->keyEnvironment();
        Log::error("Using $env keys for payment");

        try {
            return response()->json($client->charge($token, $amountInCents, $currency, $metadata));
        } catch (ApiKeyException $e) {
            Log::error("Failed to charge card with token $token, amount $currency $amountInCents : " . $e->getMessage());
            return response()->json(['charge_error' => $e], 400);
        } catch (DeclinedException $e) {
            Log::error("Failed to charge card with token $token, amount $currency $amountInCents : " . $e->getMessage());
            return response()->json(['charge_error' => $e], 400);
        } catch (InternalException $e) {
            Log::error("Failed to charge card with token $token, amount $currency $amountInCents : " . $e->getMessage());
            return response()->json(['charge_error' => $e], 400);
        }
    }

}
