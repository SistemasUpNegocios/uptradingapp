<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;

$stripe = new StripeClient('sk_test_51JavqOIfTBWbGOsO0rOIrHt7aothBTtg9wFhBUJTfavEtaSLdCqL813xKDKSzQzWyRtXGxdlerzkAaSBlrFkAyg100mjrnXfUs');

class PinController extends Controller
{
    public function retrieveInformation()
    {
        $stripe = new StripeClient('sk_test_51JavqOIfTBWbGOsO0rOIrHt7aothBTtg9wFhBUJTfavEtaSLdCqL813xKDKSzQzWyRtXGxdlerzkAaSBlrFkAyg100mjrnXfUs');

        $data = $stripe->customers->allSources(
            'cus_LXzNe3TGNQau3I',
            ['object' => 'card']
        );

        echo json_encode($data);
    }

    public function changeCardPin()
    {
        $stripe = new StripeClient('sk_test_51JavqOIfTBWbGOsO0rOIrHt7aothBTtg9wFhBUJTfavEtaSLdCqL813xKDKSzQzWyRtXGxdlerzkAaSBlrFkAyg100mjrnXfUs');

        $data = $stripe->issuing->cards->update(
            'ic_1KrlbZIfTBWbGOsOR5zLQgVr',
            ['spending_controls' => ['allowed_categories' => ['ac_refrigeration_repair']]]
        );
        
        // $data = $stripe->issuing->cards->update(
        //     'ic_1KrlbZIfTBWbGOsOR5zLQgVr',
        //     ['pin' => ['encrypted_number' => '0000']]
        // );

        echo json_encode($data);
    }

    // public function changeCardPin()
    // {
    //     $stripe = new StripeClient('sk_test_51JavqOIfTBWbGOsO0rOIrHt7aothBTtg9wFhBUJTfavEtaSLdCqL813xKDKSzQzWyRtXGxdlerzkAaSBlrFkAyg100mjrnXfUs');

    //     $data = $stripe->issuing->cards->update(
    //         'ic_1KrlbZIfTBWbGOsOR5zLQgVr',
    //         ['metadata' => ['pin' => '0000']]
    //     );

    //     echo json_encode($data);
    // }
}
