<?php

declare(strict_types=1);

require_once 'user.php';
require_once 'cart.php';

class Customer extends User
{
    public Cart $cart;

    public function __construct(string $name)
    {
        parent::__construct(name: $name);
        $this->cart = new Cart(owner: $this); // Customerインスタンスは生成されると、自身をオーナーとするカートを持ちます。
    }
}
