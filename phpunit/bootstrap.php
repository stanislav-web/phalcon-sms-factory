<?php
if(file_exists('./vendor/autoload.php'))
    require_once './vendor/autoload.php';
elseif(file_exists('../vendor/autoload.php'))
    require_once '../vendor/autoload.php';
elseif(file_exists('vendor/autoload.php'))
    require_once 'vendor/autoload.php';
elseif(file_exists('../../../vendor/autoload.php'))
    require_once '../../../vendor/autoload.php';
elseif(file_exists('../../../../vendor/autoload.php'))
    require_once '../../../../vendor/autoload.php';
else
    require_once '../../vendor/autoload.php';