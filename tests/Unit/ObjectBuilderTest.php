<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Tests\Unit\Dummies\Builder\MismatchedTypeTestObjectBuilder;
use Tests\Unit\Dummies\Builder\MissingArgumentTestObjectBuilder;
use Tests\Unit\Dummies\Builder\TestObject;
use Tests\Unit\Dummies\Builder\TestObjectBuilder;
use Tests\Unit\Dummies\Builder\UnnecessaryArgumentTestObjectBuilder;
use Webmaesther\EventSourcing\Exceptions\IncorrectDefinitionException;
use Webmaesther\EventSourcing\ObjectBuilder;

describe(ObjectBuilder::class, function () {

    it('is abstract', function () {

        expect(ObjectBuilder::class)->toBeAbstract();

    });

    it('resolves the factory out of the container', function () {

        expect(TestObjectBuilder::new())->toBeInstanceOf(TestObjectBuilder::class);

    });

    it('has an abstract class property', function () {

        expect(TestObjectBuilder::new())->toHaveProperty('class');

    });

    it('cannot build the object when the definition has missing constructor arguments', function () {

        expect(fn () => MissingArgumentTestObjectBuilder::new()->build())
            ->toThrow(IncorrectDefinitionException::class);

    });

    it('cannot build the object when the definition has constructor arguments with incorrect type', function () {

        expect(fn () => MismatchedTypeTestObjectBuilder::new()->build())
            ->toThrow(IncorrectDefinitionException::class);

    });

    it('cannot build the object when the definition has unnecessary constructor arguments', function () {

        expect(fn () => UnnecessaryArgumentTestObjectBuilder::new()->build())
            ->toThrow(IncorrectDefinitionException::class);

    });

    it('builds its object', function () {

        $factory = TestObjectBuilder::new();

        expect($factory->build())->toBeInstanceOf(TestObject::class);

    });

    it('builds a collection of objects', function () {

        $factory = TestObjectBuilder::new();

        expect($factory->count(2)->build())
            ->toBeInstanceOf(Collection::class)
            ->toHaveCount(2)
            ->each->toBeInstanceOf(TestObject::class);

    });

    it('does not accept 0 or less as count', function () {

        expect(fn () => TestObjectBuilder::new()->count(0))
            ->toThrow(InvalidArgumentException::class)
            ->and(fn () => TestObjectBuilder::new()->count(-1))
            ->toThrow(InvalidArgumentException::class)
            ->and(fn () => TestObjectBuilder::new()->count(-100))
            ->toThrow(InvalidArgumentException::class);

    });

    it('can change the state on the fly', function () {

        $factory = TestObjectBuilder::new();

        $object = $factory->state([
            'message' => 'New Message',
            'cost' => 100,
        ])->build();

        expect($object->message)->toBe('New Message')
            ->and($object->cost)->toBe(100);

    });

});
