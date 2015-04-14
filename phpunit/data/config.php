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
        ],
        'Clickatell'    => [
            'api_id'    => 3537200,
            'user'      => 'SWEBTEST',
            'password'  => 'e7e15653',
            'from'      => 'Stanislav',
            'request_method' => 'GET'
        ],

//        'MessageBird'   => [
//            'originator'   => '434',
//            'access_key'   => 'test_UHaeiTLfAe3avOULhawXvn7iR',
//            'request_method' => 'GET'
//        ],


    ]
];