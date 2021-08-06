<?php

/*
 * This is the Yoco configuration file
 */

return [

    // enter the secret key you received from yoco
    'secret_key' => env('YOCO_SECRET_KEY','sk_test_960bfde0VBrLlpK098e4ffeb53e1'),  // pull from .env
    // 'secret_key' => 'sk_test_960bfde0VBrLlpK098e4ffeb53e1', // entered directly here

    // enter your public key you received from yoco
    'public_key' => env('YOCO_PUBLIC_KEY','pk_test_ed3c54a6gOol69qa7f45'), // pull from .env
    // 'public_key' => 'pk_test_ed3c54a6gOol69qa7f45', // entered directly here

    // add the demo routes into your route list  (/yoco/demo/chooser, /yoco/demo/inline, /yoco/demo/popup)
    'add_demo_routes' => true,

    // When you publish the sources to laravel, you get a ChargeController, this adds the route for that controller (/charge)
    'add_charge_routes' => true,
];
