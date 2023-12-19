<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    dump($context['APP_ENV']);
    dump($context['APP_DEBUG']);
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
