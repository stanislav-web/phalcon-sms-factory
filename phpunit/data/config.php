<?php
return [
    // True SMS sending data

    'sms' => [
        'Nexmo'         =>  [
            'from'      => 'Phalcon Dev',
            'api_key'   => '90c8f84f',
            'api_secret'=> 'e7e15653',
            'type'      => 'unicode',
            'request_method' => 'GET'
        ],
        'BulkSMS'   =>  [
            'username'  => 'SWEB',
            'password'  => 'e7e15653',
        ],
        'SmsAero' => [
            'from'          => 'Test',
            'user'          => 'stanisov@gmail.com',
            'password'      => 'e7e15653',
        ],
        'SmsUkraine'       =>  [
            'from'          => 'Stanislav',
            'login'         => '380954916517',
            'password'      => 'e7e15653',
            'version'       => 'http',
        ],
        'SMSC'       =>  [
            'login'     => 'SwebTester',
            'psw'       => 'e7e15653',
            'charset'   => 'utf-8',
            'sender'    => 'SWEB',
            'translit'  => 0,
        ],

        'SMSRu' => [
            'api_id'    => '66bf9913-5cda-2654-9980-f440a1f293eb'
        ]

//        'MessageBird'   => [
//            'originator'   => '434',
//            'access_key'   => 'test_UHaeiTLfAe3avOULhawXvn7iR',
//        ],
//        'Clickatell'    => [
//            'api_id'    => '',
//            'user'      => '',
//            'password'  => '',
//            'form'      => ''
//        ],

    ],

    // Error data for testing exceptions

    'smsError' => [
        'Nexmo'         =>  [
            'from'      => 'Phalcon Dev',
            'api_key'   => '11111111',
            'api_secret'=> '11111111',
            'type'      => '11111111'
        ],
        'BulkSMS'   =>  [
            'username'  => 'SWEB',
            'password'  => '11111111',
        ],
        'Clickatell'    => [
            'api_id'    => '11111111',
            'user'      => '11111111',
            'password'  => '11111111',
            'form'      => '11111111'
        ],
        'MessageBird'   => [
            'originator'   => '434',
            'access_key'   => '11111111',
        ],
        'SmsAero' => [
            'from'          => 'Test',
            'user'          => 'SWEB',
            'password'      => '11111111',
        ],
        'SMSC'       =>  [
            'login'     => '11111111',
            'psw'       => '11111111',
            'charset'   => '11111111',
            'sender'    => '11111111',
            'translit'  => '11111111',
        ],
        'SmsUkraine'       =>  [
            'from'          => 'Stanislav',
            'login'         => '11111111',
            'password'      => '1111111111',
            'version'       => 'http',
        ],
        'SMSRu' => [
            'api_id'    => '11111111'
        ]
    ]
];