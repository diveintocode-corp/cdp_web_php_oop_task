<?php
require_once "item_manager.php";
require_once "wallet.php";

class User
{
    use ItemManager;

    // attr_accessor $name;
    // attr_reader :wallet

    public function __construct($name)
    {
        $this->name = $name;
        $this->wallet = new Wallet($this); # UserインスタンスまたはUserを継承したクラスのインスタンスは生成されると、自身をオーナーとするウォレットを持ちます。
    }
}
