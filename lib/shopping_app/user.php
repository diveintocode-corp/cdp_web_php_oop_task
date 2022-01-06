<?php

declare(strict_types=1);

require_once 'item_manager.php';
require_once 'wallet.php';

class User
{
    use ItemManager;

    public Wallet $wallet;
    public string $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->wallet = new Wallet(owner: $this); // UserインスタンスまたはUserを継承したクラスのインスタンスは生成されると、自身をオーナーとするウォレットを持ちます。
    }
}
