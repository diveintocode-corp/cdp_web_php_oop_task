<?php

declare(strict_types=1);

require_once 'ownable.php';

class Wallet
{
    use Ownable;

    public int $balance;

    /**
     * @param User $owner
     */
    public function __construct(User $owner)
    {
        $this->owner = $owner;
        $this->balance = 0;
    }

    /**
     * @param int $amount
     */
    public function deposit(int $amount): void
    {
        $tmp = $this->balance;
        $tmp += $amount;
        $this->balance = $tmp;
    }

    /**
     * @param int $amount
     * @return int
     */
    public function withdraw(int $amount): int
    {
        if ($this->balance < $amount) return 0;

        $tmp = $this->balance;
        $tmp -= $amount;
        $this->balance = $tmp;
        return $amount;
    }
}
