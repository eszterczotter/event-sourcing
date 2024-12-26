<?php

declare(strict_types=1);

use Tests\Integration\Dummies\Events\TestEventWithTypedArrayProperty;
use Tests\Integration\Dummies\Events\TestEventWithUntypedArrayProperty;
use Tests\Unit\Dummies\Events\TestEvent;
use Webmaesther\EventSourcing\Exceptions\CannotUnserializeException;
use Webmaesther\EventSourcing\Serializers\JsonEventSerializer;

describe(JsonEventSerializer::class, function () {

    it('it validates the payload',
        /** @throws CannotUnserializeException */
        function () {

            $serializer = new JsonEventSerializer;

            expect(fn () => $serializer->unserialize('{"_class":"bar"}'))
                ->toThrow(CannotUnserializeException::class)
                ->and(fn () => $serializer->unserialize('{"_class":"bar","_data":[]}'))
                ->toThrow(CannotUnserializeException::class)
                ->and(fn () => $serializer->unserialize('{"_data":[]}'))
                ->toThrow(CannotUnserializeException::class)
                ->and(fn () => $serializer->unserialize(sprintf('{"_class":%s,"_data":"string"}', json_encode(TestEvent::class))))
                ->toThrow(CannotUnserializeException::class);
        });

    it('serializes typed properties as array', function () {

        $serializer = new JsonEventSerializer;

        expect($serializer->unserialize(sprintf('{"_class":%s,"_data":{"data":{"_class":"bar"}}}', json_encode(TestEventWithTypedArrayProperty::class))))
            ->toEqual(new TestEventWithTypedArrayProperty(['_class' => 'bar']))
            ->and($serializer->unserialize(sprintf('{"_class":%s,"_data":{"data":{"_data":[]}}}', json_encode(TestEventWithTypedArrayProperty::class))))
            ->toEqual(new TestEventWithTypedArrayProperty(['_data' => []]))
            ->and($serializer->unserialize(sprintf('{"_class":%s,"_data":{"data":{"_class":"bar","_data":[]}}}', json_encode(TestEventWithTypedArrayProperty::class))))
            ->toEqual(new TestEventWithTypedArrayProperty(['_class' => 'bar', '_data' => []]));

    });

    it('serializes untyped properties as array', function () {

        $serializer = new JsonEventSerializer;

        expect($serializer->unserialize(sprintf('{"_class":%s,"_data":{"data":{"_class":"bar"}}}', json_encode(TestEventWithUntypedArrayProperty::class))))
            ->toEqual(new TestEventWithUntypedArrayProperty(['_class' => 'bar']))
            ->and($serializer->unserialize(sprintf('{"_class":%s,"_data":{"data":{"_data":[]}}}', json_encode(TestEventWithUntypedArrayProperty::class))))
            ->toEqual(new TestEventWithUntypedArrayProperty(['_data' => []]))
            ->and(fn () => $serializer->unserialize(sprintf('{"_class":%s,"_data":{"data":{"_class":"bar","_data":[]}}}', json_encode(TestEventWithUntypedArrayProperty::class))))
            ->toThrow(CannotUnserializeException::class);

    });

})->covers(JsonEventSerializer::class);
