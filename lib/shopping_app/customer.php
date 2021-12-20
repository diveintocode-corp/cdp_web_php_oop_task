<?php
require_once "user.php";
require_once "cart.php";

class Customer extends User
{
    // attr_reader :cart
    

    public function __construct($name)
    {
        // super(name)
    $this->cart = new Cart($this); # Customerインスタンスは生成されると、自身をオーナーとするカートを持ちます。
    $this->wallet = new Wallet($this);
    $this->name = $name;
    }
}
