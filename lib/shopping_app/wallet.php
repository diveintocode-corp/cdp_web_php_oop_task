<?php

declare(strict_types=1);

class Wallet
{
    // attr_reader :balance

    public function __construct($owner)
    {
        $this->owner = $owner;
        $this->balance = 0;
    }

    public function deposit($amount)
    {
        $this->balance += (int)$amount;
    }

    public function withdraw($amount)
    {
        // return unless @balance >= amount
        if ($this->balance < $amount) {
            return;
        }

        $this->balance -= $amount;
        $amount;
    }
}
