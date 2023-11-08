<?php

return [
    //user
    'email' => ['required', 'string', 'email', 'max:100'],
    'password' => ['required', 'between:6,255', 'email', 'max:100'],
    'phone_number' => ['between:10,12'],
    'address' => ['string|max:255'],

    //common
    'boolean' => 'required|boolean',
    'numeric' => 'required|numeric',
];
