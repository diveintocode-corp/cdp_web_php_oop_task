<?php

declare(strict_types=1);

include_once 'user.php';

class Seller extends User
{
    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct(name: $name);
    }

}
