# Multiple gateway SMS Sender factory

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/stanislav-web/phalcon-sms-factory/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/stanislav-web/Searcher/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/stanislav-web/phalcon-sms-factory/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/stanislav-web/phalcon-sms-factory/?branch=master) [![Build Status](https://travis-ci.org/stanislav-web/Searcher.svg?branch=master)](https://travis-ci.org/stanislav-web/phalcon-sms-factory) [![Total Downloads](https://poser.pugx.org/stanislav-web/phalcon-sms-factory/downloads.svg)](https://packagist.org/packages/stanislav-web/phalcon-sms-factory) [![Latest Stable Version](https://poser.pugx.org/stanislav-web/phalcon-sms-factory/v/stable.svg)](https://packagist.org/packages/stanislav-web/phalcon-sms-factory)

## Description
This service makes SMS through a variety of providers. You can easily implement your own providers using the interface design. _(Currently under TDD)_
At the moment, provides an interface to send and check your balance for the next:

    - BulkSMS
    - Clickatell
    - MessageBird
    - Nexmo
    - SmsAero
    - SMSC
    - SmsUkraine

## Change Log

#### In Future
    - Support SMS mass mailing

#### [v 1.2.2-beta] 2015-02-08
    - **Add view balance**
    - Add development info (API) / UML
    - Reformat to PSR-1/PSR-2

#### [v 1.1-beta] 2015-02-07
    - Add response debugger (Show server response headers)

#### [v 1.0-beta] 2015-02-06
    - Sending SMS use multiple providers

## Compatible
- PSR-0, PSR-1, PSR-2, PSR-4 Standards

## System requirements
- PHP 5.4 >
- Phalcon extension 1.3.x
- PHP libcurl or Stream Socket client

## Install
First update your dependencies through composer. Add to your composer.json:
```php
"require": {
    "stanislav-web/phalcon-sms-factory": "1.*",
}
```
Then run to update dependency and autoloader
```python
php composer.phar update
php composer.phar install
```
or just
```
php composer.phar require stanislav-web/phalcon-sms-factory 1.*
```
_(Do not forget to include the composer autoloader)_

You can create an injectable service
```php
    $di->set('SMS', function () use ($di) {

        return new SMSFactory\Sender($di);
    });
```
## Usage

#### Configure  providers
SMS services have a variety of settings, both mandatory and optional.
You can select them in the global configuration file of your project.
I intentionally did not make the settings in each provider, as this service will be maintained and no time to change.
Therefore, when updating via the composer, your settings will not be overwritten,
if you will be making their to global application config. See example:
```php
<?php
    // add to your app config and write down your settings .The key 'sms' is required
    'sms'   =>  [
        'BulkSMS'   =>  [
            'username'  => '',
            'password'  => '',
        ],
        'Clickatell'    =>  [
            'api_id'    => '',
            'user'      => '',
            'password'  => '',
            'form'      => ''
        ],
        'MessageBird'   => [
            'originator'   => '',
            'access_key'   => '',
        ],
        'Nexmo'         =>  [
            'from'          => '',
            'api_key'       => '',
            'api_secret'    => '',
            'type'          => ''
        ],
        'SmsAero'       =>  [
            'from'          => '',
            'user'          => '',
            'password'      => '',
        ],
        'SMSC'       =>  [
            'login'     => '',
            'psw'       => '',
            'charset'   => '',
            'sender'    => '',
            'translit'  => '',
            'fmt'       => '',
        ],
        'SmsUkraine'       =>  [
            'from'          => '',
            'login'         => '',
            'password'      => '',
            'version'       => '',
             'flash'        => '',
        ],
    ];
```

#### Send SMS and view balance
Now you can call your created service of sending sms.

```php
<?php

    // get sms service
    $sms = $this->di->get('SMS');

    // send message via SmsAero (available 7 providers)

    $response = $sms->call('SmsAero')->setRecipient('NUMBER')->send('MESSAGE'));

    // get balance of SmsAero account
    $response = $sms->call('SmsAero')->balance();

    // use debug to show headers
    $response = $sms->call('SmsProvider')->debug(true)->setRecipient('NUMBER')->send('MESSAGE'));
    $response = $sms->call('SmsProvider')->debug(true)->balance();

```

## Unit Test
_Currently under TDD_

##[Change Log](https://github.com/stanislav-web/phalcon-sms-factory/blob/master/CHANGELOG.md "Change Log")

## Contributing and development
I have enclosed instructions API and related classes (https://github.com/stanislav-web/phalcon-sms-factory/blob/master/SMS-factory.uml "Diagram").

*I am accept bug reports, new feature requests and pull requests in GitHub*.

If you have a question about how to use this service, please see the [README](https://github.com/stanislav-web/phalcon-sms-factory/blob/master/README.md).

If you have a change or new feature in mind, please see [README](https://github.com/stanislav-web/phalcon-sms-factory/blob/master/README.md) again and follow *DRI* (development rules interfaces).

**You can add new providers following interfaces:**
- (https://github.com/stanislav-web/phalcon-sms-factory/blob/master/src/SMSFactory/Aware/ProviderConfigInterface.php "ProviderConfigInterface")
- (https://github.com/stanislav-web/phalcon-sms-factory/blob/master/src/SMSFactory/Aware/ProviderInterface.php "ProviderInterface")
**You can add own or choise exists of request's client. Also available:**
- (https://github.com/stanislav-web/phalcon-sms-factory/blob/master/src/SMSFactory/Aware/ClientProviders/CurlTrait.php "PHP libcurl")
- (https://github.com/stanislav-web/phalcon-sms-factory/blob/master/src/SMSFactory/Aware/ClientProviders/StreamTrait.php "Stream Socket Client")

##[Issues](https://github.com/stanislav-web/phalcon-sms-factory/issues "Issues")

