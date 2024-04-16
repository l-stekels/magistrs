<?php

declare(strict_types=1);

namespace App\Tests\E2E;

use Symfony\Component\Panther\PantherTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

abstract class BaseE2ETestCase extends PantherTestCase
{
    use HasBrowser;
    use ResetDatabase;
    use Factories;
}
