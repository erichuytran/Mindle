<?php
declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Application\Actions\ActionPayload;
use App\Domain\User\UserRepository;
use App\Domain\User\User;
use DI\Container;
use Tests\TestCase;
use App\Application\Actions\User\TestAction;


class TestActionTest extends TestCase
{
    public function testGetTest()
    {
        $nombre = 100;
        $calcul = getTest($nombre);

        $this->assertEquals(500, $calcul);
    }
}
