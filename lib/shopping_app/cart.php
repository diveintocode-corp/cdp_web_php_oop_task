<?php

declare(strict_types=1);

include_once 'item_manager.php';

class Cart
{
    use ItemManager;

    private array $items;

    public function __construct(Customer $owner)
    {
        $this->owner = $owner;
        $this->items = [];
    }

    /**
     * Cart にとっての items は自身の $this->items() としたいため、ItemManager の items()メソッドをオーバーライドします。
     * Cart インスタンスが Item インスタンスを持つときは、オーナー権限の移譲をさせることなく、自身の $items に格納(Cart->add())するだけだからです。
     */
    public function items(): array
    {
        return $this->items;
    }

    public function add(Item $item): void
    {
        $this->items[] = $item;
    }

    public function totalAmount(): int
    {
        return array_sum(array_column($this->items, 'price'));
    }

    public function checkOut(): void
    {
        if ($this->owner->wallet->balance < $this->totalAmount()) return;
        // ## 要件
        //   - カートの中身（Cart#items）のすべてのアイテムの購入金額が、カートのオーナーのウォレットからアイテムのオーナーのウォレットに移されること。
        //   - カートの中身（Cart#items）のすべてのアイテムのオーナー権限が、カートのオーナーに移されること。
        //   - カートの中身（Cart#items）が空になること。

        // ## ヒント
        //   - カートのオーナーのウォレット ==> self.owner.wallet
        //   - アイテムのオーナーのウォレット ==> item.owner.wallet
        //   - お金が移されるということ ==> (？)のウォレットからその分を引き出して、(？)のウォレットにその分を入金するということ
        //   - アイテムのオーナー権限がカートのオーナーに移されること ==> オーナーの書き換え(item.owner = ?)
    }
}
