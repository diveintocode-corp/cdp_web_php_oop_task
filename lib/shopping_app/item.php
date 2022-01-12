<?php

declare(strict_types=1);

class Item
{
    private static array $instances;
    public string $name;
    public int $price;

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
     */
    public static function all(): array
    {
        return self::$instances;
    }

    public function label(): bool|string
    {
        return json_encode([
            'name'  => $this->name,
            'price' => $this->price
        ], JSON_UNESCAPED_UNICODE);
    }
}
