<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class TestAction extends UserAction
{
/**
     * {@inheritdoc}
     * 
     * 
     * 
     */


    protected function getTest($nombre){
        $result = $nombre * 5;
        return $result;
    }

}