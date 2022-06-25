<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Builder;

use AlecRabbit\Tests\Spinner\Helper\PickLock;
use AlecRabbit\Tests\Spinner\TestCase;

final class ConfigBuilderTest extends TestCase
{
    /** @test */
    public function defaultConfigInstance(): void
    {
        $config = self::getDefaultConfig();
        self::assertTrue($config->isAsynchronous());
    }

    /** @test */
    public function defaultBuilderInstance(): void
    {
        $builder = self::getConfigBuilder();
        self::assertNull(self::getValue('loop', from: $builder));
        self::assertNull(self::getValue('hideCursor', from: $builder));
        self::assertNull(self::getValue('driver', from: $builder));
        self::assertNull(self::getValue('container', from: $builder));
        self::assertNull(self::getValue('intervalVisitor', from: $builder));
        self::assertNull(self::getValue('twirlerFactory', from: $builder));
        self::assertNull(self::getValue('twirlerBuilder', from: $builder));
        self::assertNull(self::getValue('containerFactory', from: $builder));
        self::assertNull(self::getValue('synchronousMode', from: $builder));
        self::assertNull(self::getValue('shutdownDelaySeconds', from: $builder));
        self::assertNull(self::getValue('interruptMessage', from: $builder));
        self::assertNull(self::getValue('finalMessage', from: $builder));
        self::assertNull(self::getValue('terminalColorSupport', from: $builder));
        self::assertNull(self::getValue('loopFactory', from: $builder));
        self::assertNull(self::getValue('styleProvider', from: $builder));
        self::assertNull(self::getValue('charProvider', from: $builder));
        self::assertNull(self::getValue('stylePatternExtractor', from: $builder));
        self::assertNull(self::getValue('charPatternExtractor', from: $builder));
        self::assertNull(self::getValue('styleFrameCollectionFactory', from: $builder));
        self::assertNull(self::getValue('charFrameCollectionFactory', from: $builder));
        self::assertNull(self::getValue('interval', from: $builder));

        PickLock::callMethod($builder, 'processDefaults');

        self::assertNotNull(self::getValue('loop', from: $builder));
        self::assertNotNull(self::getValue('hideCursor', from: $builder));
        self::assertNotNull(self::getValue('driver', from: $builder));
        self::assertNotNull(self::getValue('container', from: $builder));
        self::assertNotNull(self::getValue('intervalVisitor', from: $builder));
        self::assertNotNull(self::getValue('twirlerFactory', from: $builder));
        self::assertNotNull(self::getValue('twirlerBuilder', from: $builder));
        self::assertNotNull(self::getValue('containerFactory', from: $builder));
        self::assertNotNull(self::getValue('synchronousMode', from: $builder));
        self::assertNotNull(self::getValue('shutdownDelaySeconds', from: $builder));
        self::assertNotNull(self::getValue('interruptMessage', from: $builder));
        self::assertNotNull(self::getValue('finalMessage', from: $builder));
        self::assertNotNull(self::getValue('terminalColorSupport', from: $builder));
        self::assertNotNull(self::getValue('loopFactory', from: $builder));
        self::assertNotNull(self::getValue('styleProvider', from: $builder));
        self::assertNotNull(self::getValue('charProvider', from: $builder));
        self::assertNotNull(self::getValue('stylePatternExtractor', from: $builder));
        self::assertNotNull(self::getValue('charPatternExtractor', from: $builder));
        self::assertNotNull(self::getValue('styleFrameCollectionFactory', from: $builder));
        self::assertNotNull(self::getValue('charFrameCollectionFactory', from: $builder));
        self::assertNotNull(self::getValue('interval', from: $builder));

    }
}
