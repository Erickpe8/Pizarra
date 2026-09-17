<?php

use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

afterEach(function () {
    URL::forceScheme(null);
});

it('generates https asset urls when the request is forwarded as https', function () {
    Route::get('/asset-scheme', function () {
        return asset('build/assets/app.css');
    });

    $response = $this->get('http://localhost/asset-scheme', [
        'X-Forwarded-Proto' => 'https',
    ]);

    $response->assertOk();
    expect($response->getContent())->toStartWith('https://');
});

it('forces https urls in production', function () {
    app()->instance('env', 'production');

    (new AppServiceProvider(app()))->boot();

    expect(url('/'))->toStartWith('https://');
});

it('does not force https urls outside production', function () {
    expect(url('/'))->toStartWith('http://');
});
