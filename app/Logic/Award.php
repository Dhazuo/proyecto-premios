<?php


namespace App\Logic;


class Award
{
    public array $all_awards;

    public function __construct($awards)
    {
        $this->all_awards = $awards;
    }

    public function selectedAward(): string
    {
        $awards = $this->all_awards;
        $selected_award = $awards[rand(0, (count($awards)-1))];
        return $selected_award;
    }
}
