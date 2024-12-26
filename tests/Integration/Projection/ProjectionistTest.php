<?php

use Webmaesther\EventSourcing\EventBus;
use Webmaesther\EventSourcing\Model\SourcedEvent;
use Webmaesther\EventSourcing\Projection\Projectionist;
use Tests\Integration\Dummies\TestProjection;
use Tests\Unit\Dummies\Events\TestEvent;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;

describe(Projectionist::class, function () {

    it('plays an event', function () {

        $projectionist = app(Projectionist::class);
        $projectionist->control(TestProjection::class);

        $projectionist->play(new SourcedEvent(new TestEvent, 'uuid'));

        assertDatabaseHas(TestProjection::class, [
            'name' => 'Reacted Name',
        ]);
    });

    it('replays an event', function () {

        $projectionist = app(Projectionist::class);
        $projectionist->control(TestProjection::class);

        $projectionist->replay(new SourcedEvent(new TestEvent, 'uuid'));

        assertDatabaseHas(TestProjection::class, [
            'name' => 'Projected Name',
        ]);

    });

    it('rewinds all projections', function () {

        $projectionist = app(Projectionist::class);
        $bus = app(EventBus::class);
        $projectionist->control(TestProjection::class);
        $bus->dispatch(new SourcedEvent(new TestEvent, 'uuid'));
        assertDatabaseCount(TestProjection::class, 1);

        $projectionist->rewind();

        assertDatabaseEmpty(TestProjection::class);

    });

    it('rewinds a specific projection', function () {

        app(Projectionist::class)->control(TestProjection::class);
        app(EventBus::class)->dispatch(new SourcedEvent(new TestEvent, 'uuid'));
        assertDatabaseCount(TestProjection::class, 1);

        new Projectionist()->rewind(TestProjection::class);

        assertDatabaseEmpty(TestProjection::class);

    });

    it('throws an exception for non projection rewinds', function () {

        expect(fn () => new Projectionist()->rewind(stdClass::class))
            ->toThrow(InvalidArgumentException::class);
    });

});
