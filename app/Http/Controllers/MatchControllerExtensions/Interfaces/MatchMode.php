<?php

namespace App\Http\Controllers\MatchControllerExtensions\Interfaces;

interface MatchMode
{
    public function checkCapacity();
    public function validate_match();
    public function payPlayers();
}