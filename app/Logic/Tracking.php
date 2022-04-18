<?php


namespace App\Logic;


class Tracking
{
    public string $tracking;

    public function tracking(): string
    {
        $length = random_bytes(5);
        return bin2hex($length);
    }
}
