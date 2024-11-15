<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class LotteryPurchased
{
    use SerializesModels;

    public $user;
    public $lottery;

    public function __construct($user, $lottery)
    {
        $this->user = $user;
        $this->lottery = $lottery;
    }
}
