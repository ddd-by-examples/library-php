<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Akondas\Library\Lending\DailySheet\Infrastructure\DbalDailySheet;
use Akondas\Library\Lending\DailySheet\Model\DailySheet;
use Symfony\Component\Clock\ClockInterface;
use Symfony\Component\Clock\NativeClock;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services->set(NativeClock::class);
    $services->alias(ClockInterface::class, NativeClock::class);

    $services->set(DbalDailySheet::class);
    $services->alias(DailySheet::class, DbalDailySheet::class);

    if (in_array($configurator->env(), ['dev', 'test'], true)) {
        $services->set(DbalDailySheet::class)->public();
    }
};
