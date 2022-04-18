<?php


namespace App\Logic;


class Participation
{
    private $email;

    public function __construct(...$params)
    {
        $this->email = $params[0];
    }
    public function generateParticipation(): string
    {
        $length = random_bytes(strlen($this->email));
        return bin2hex($length);

    }
}
