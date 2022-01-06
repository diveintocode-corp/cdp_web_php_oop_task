<?php

declare(strict_types=1);

require_once 'ownable.php';

class Item
{
    use Ownable;

    private static array $instances;
    private string $name;
    private int $price;

    /**
     * @param string $name
     * @param int $price
     * @param User|null $owner
     */
    public function __construct(string $name, int $price, ?User $owner = null)
    {
        $this->name = $name;
        $this->price = $price;
        $this->owner = $owner;
        // Itemインスタンスの生成時、そのItemインスタンス(self)は、$instancesというクラス変数に格納されます。
        self::$instances[] = $this;
    }

    /**
     * self::$instances を返します ==> Item.all() でこれまでに生成された Item インスタンスを全て返すということです。
     * @return array
     */
    public static function all(): array
    {
        return self::$instances;
    }

    function label()
    {
        // { name: name, price: price }
        $name = "name";
        $price = "price";
    }
}