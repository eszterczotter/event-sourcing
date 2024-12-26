<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

use Illuminate\Support\Str;
use PHPUnit\Framework\Assert;

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Integration');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toHavePublicProperty', function (string $property) {
    expect(new ReflectionObject($this->value)->getProperty($property)->isPublic())->toBeTrue();
});

expect()->extend('toBeUlid', function () {

    Assert::assertIsString($this->value);
    Assert::assertTrue(
        Str::isUlid($this->value),
        "The value {$this->value} is not valid ULID.",
    );

    return $this;
});

expect()->extend('toHaveFinalMethod', function (string $method) {
    Assert::assertIsString($this->value);
    Assert::assertTrue(
        new ReflectionMethod($this->value, $method)->isfinal(),
        "The method {$this->value}::{$method} is not a final public method.",
    );

    return $this;
});

expect()->extend('toHaveFinalMethods', function (array $methods) {
    foreach ($methods as $method) {
        expect($this->value)->toHaveFinalMethod($method);
    }

    return $this;
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/
