<?php

namespace Test\Application\UseCase\GetSithFleet;

use PHPUnit\Framework\TestCase;
use StarWars\Application\UseCase\GetSithFleet\GetSithFleet;
use StarWars\Domain\Fleet\Fleet;
use StarWars\Domain\Fleet\FleetFactoryInterface;
use StarWars\Domain\Repository\ShipRepositoryInterface;
use StarWars\Domain\Ship\Ship;

class GetSithFleetTest extends TestCase
{
    private GetSithFleet $useCase;
    private ShipRepositoryInterface $shipRepository;
    private FleetFactoryInterface $fleetFactory;

    public function setUp(): void
    {
        $this->shipRepository = $this->getMockBuilder(ShipRepositoryInterface::class)->getMock();
        $this->fleetFactory = $this->createMock(FleetFactoryInterface::class);

        $this->useCase = new GetSithFleet(
            $this->shipRepository,
            $this->fleetFactory
        );
    }

    public function testItShouldReturnListOfShipsWhenThereAreShipsAvailable(): void
    {
        $ships = [
            $this->createMock(Ship::class),
            $this->createMock(Ship::class)
        ];
        $fleet = new Fleet($ships);

        $this->shipRepository->expects($this->once())
            ->method('getAllShips')
            ->willReturn($ships);
        $this->fleetFactory
            ->expects($this->once())
            ->method('createFleet')
            ->with($ships)
            ->willReturn($fleet);

        $result = $this->useCase->__invoke();
        $this->assertSame($fleet, $result);
    }
}