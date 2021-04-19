<?php
declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Application\Actions\ActionPayload;
use App\Domain\User\UserRepository;
use App\Domain\User\User;
use DI\Container;
use Tests\TestCase;
use App\Application\Actions\User\Calculator;

//Classe temporaire pour les tests unitaires
class calculatorTest extends TestCase
{
    //Test unitaire fonction testAdd de la classe temporaire Calculator
    public function testAdd(): void
    {
        $calculator = new Calculator();
        $result = $calculator->add(30, 12);

        $this->assertEquals(42, $result);
    }
}
