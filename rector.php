<?php

declare(strict_types=1);

use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\Symfony\Set\SensiolabsSetList;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_81,
    ]);
};
