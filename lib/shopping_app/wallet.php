<?php

declare(strict_types=1);

class Wallet
{
    public int $balance;

    public function __construct(User $owner)
    {
        $this->owner = $owner;
        $this->balance = 0;
    }

    public function deposit(int $amount): void
    {
        $tmp = $this->balance;
        $tmp += $amount;
        $this->balance = $tmp;
    }

    public function withdraw(int $amount): int
    {
        if ($this->balance < $amount) return 0;

        $tmp = $this->balance;
        $tmp -= $amount;
        $this->balance = $tmp;
        return $amount;
    }
}
