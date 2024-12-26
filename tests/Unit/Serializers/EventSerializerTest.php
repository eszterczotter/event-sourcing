<?php

use Tests\Integration\Dummies\Events\TestEventWithPrivateNullableProperty;
use Tests\Integration\Dummies\Events\TestEventWithPrivateTypedProperty;
use Tests\Unit\Dummies\Events\NestedTestEvent;
use Tests\Unit\Dummies\Events\TestCurrency;
use Webmaesther\EventSourcing\Exceptions\CannotSerializeException;
use Webmaesther\EventSourcing\Exceptions\CannotUnserializeException;
use Webmaesther\EventSourcing\Serializers\EventSerializer;
use Webmaesther\EventSourcing\Serializers\JsonEventSerializer;
use Webmaesther\EventSourcing\Serializers\NativeEventSerializer;

$serializers = [
    'native' => NativeEventSerializer::class,
    'json' => JsonEventSerializer::class,
];

dataset('serializers', $serializers);

describe(EventSerializer::class, function () {

    it(
        sprintf('implements %s interface', EventSerializer::class),
        /** @param class-string<EventSerializer> $serializer */
        function (string $serializer) {

            expect($serializer)
                ->toOnlyImplement(EventSerializer::class);

        })->with('serializers');

    it(
        'throws exception for unserializable payloads',
        /**
         * @param  class-string<EventSerializer>  $serializer
         *
         * @throws CannotUnserializeException
         */
        function (string $serializer) {

            expect(fn () => (new $serializer)->unserialize(''))
                ->toThrow(CannotUnserializeException::class);

        })->with('serializers');

    it(
        'serializes events',
        /**
         * @param  class-string<EventSerializer>  $serializer
         *
         * @throws CannotSerializeException | CannotUnserializeException
         */
        function (string $serializer) {

            $event = new NestedTestEvent(
                'Test Message',
                200,
                1.5,
                ['some' => 'value'],
                new TestCurrency(200, 'HUF'),
                new TestCurrency(100, 'USD'),
                null,
                null,
            );

            expect((new $serializer)->unserialize(
                (new $serializer)->serialize($event),
            ))->toEqual($event);

        })->with('serializers');

    it(
        'can unserialize events with private typed properties',
        /**
         * @param  class-string<EventSerializer>  $serializer
         *
         * @throws CannotSerializeException | CannotUnserializeException
         */
        function (string $serializer) {

            $event = new TestEventWithPrivateTypedProperty('Test Message');

            expect((new $serializer)->unserialize(
                (new $serializer)->serialize($event),
            ))->toEqual($event);

        })->with('serializers');

    it(
        'can unserialize events with private nullable properties',
        /**
         * @param  class-string<EventSerializer>  $serializer
         *
         * @throws CannotUnserializeException | CannotSerializeException
         */
        function (string $serializer) {

            $event = new TestEventWithPrivateNullableProperty('Test Message');

            expect((new $serializer)->unserialize(
                (new $serializer)->serialize($event),
            ))->toEqual($event);

        })->with('serializers');

})->covers(array_values($serializers));
