<?php

return [
    'emails' => [

        'model'     => 'Mirbaagheri\Subscription\Emails\EmailEloquent',
        'status'    => [
            'verified'  => 1,
            'unknown'   => 2,
            'verifying' => 3,
            'spam'      => 4,
            'invalid'   => 5]

    ],
    'types' => [
        'model'     => 'Mirbaagheri\Subscription\Types\TypeEloquent',
        'status'    => [
            'active'    => true,
            'disable'   => false
        ]
    ]
];
