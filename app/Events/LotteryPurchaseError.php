<?php
namespace App\Events;

use Illuminate\Queue\SerializesModels;

class LotteryPurchaseError
{
    use SerializesModels;

    public $user;
    public $lottery;
    public $errorMessage;

    public function __construct($user, $lottery, $errorMessage)
    {
        $this->user = $user;
        $this->lottery = $lottery;
        $this->errorMessage = $errorMessage;
    }
}
