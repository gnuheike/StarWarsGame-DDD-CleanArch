<?php

namespace Test\Application\UseCase\CreateSithFleet;

use PHPUnit\Framework\TestCase;
use StarWars\Application\UseCase\CreateSithFleet\SithFleetGenerator;
use StarWars\Domain\Ship\Ship;
use StarWars\Domain\Ship\ShipProviderInterface;

class SithFleetGeneratorTest extends TestCase
{

    public function testGenerateShips(): void
    {
        $ship = $this->createMock(Ship::class);

        $providerMock = $this->createMock(ShipProviderInterface::class);
        $providerMock->expects($this->once())
            ->method('getShips')
            ->willReturn([$ship]);

        $generator = new SithFleetGenerator($providerMock);
        $ships = $generator->generateShips(100);

        $this->assertCount(100, $ships);

        $this->assertEquals(
            array_fill(0, 100, $ship),
            $ships
        );
    }
}
