<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    'weeks' => [
        'api_url' => env('WEEKS_API_URL', 'https://week.curio.codes/api/'),
    ],


    'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
    ])->toArray(),

];
