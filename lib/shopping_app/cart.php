<?php

declare(strict_types=1);

include_once 'item_manager.php';

class Cart
{
    use ItemManager;

    private Customer $owner;
    private array $items;

    /**
     * @param Customer $owner
     */
    function __construct(Customer $owner)
    {
        $this->owner = $owner;
        $this->items = [];
    }

    /**
     * Cart にとっての items は自身の $this->items() としたいため、ItemManager の items()メソッドをオーバーライドします。
     * Cart インスタンスが Item インスタンスを持つときは、オーナー権限の移譲をさせることなく、自身の $items に格納(Cart->add())するだけだからです。
     * @return array
     */
    function items(): array
    {
        return $this->items;
    }

    /**
     * @param Item $item
     */
    function add(Item $item): void
    {
        $this->items[] = $item;
    }

    function check_out()
    {
        if ($this->owner->wallet->balance < $this->total_amount()) {
            return;
        }
        # ## 要件
        #   - カートの中身（Cart#items）のすべてのアイテムの購入金額が、カートのオーナーのウォレットからアイテムのオーナーのウォレットに移されること。
        #   - カートの中身（Cart#items）のすべてのアイテムのオーナー権限が、カートのオーナーに移されること。
        #   - カートの中身（Cart#items）が空になること。

        # ## ヒント
        #   - カートのオーナーのウォレット ==> self.owner.wallet
        #   - アイテムのオーナーのウォレット ==> item.owner.wallet
        #   - お金が移されるということ ==> (？)のウォレットからその分を引き出して、(？)のウォレットにその分を入金するということ
        #   - アイテムのオーナー権限がカートのオーナーに移されること ==> オーナーの書き換え(item.owner = ?)
    }

    function total_amount()
    {
        // $this->items->sum(&:price);
        return array_sum($this->items);
    }

}
