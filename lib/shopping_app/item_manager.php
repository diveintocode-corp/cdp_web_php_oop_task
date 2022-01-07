<?php

declare(strict_types=1);

include_once 'item.php';

# このモジュールをインクルードすると、自身の所有するItemインスタンスを操れるようになります。
trait ItemManager
{
    public function pick_items($number, $quantity)
    { # numberと対応した自身の所有するItemインスタンスを指定されたquantitiy分返します。
        // $items = $stock.find{|stock| stock[:number] == number }&.dig(:items)
        // $array = (array)$this->items();
        // $item =array_search($number,$array);
        // if ($item==null) {
        //   echo "No items found\n";
        //     return;
        // }
        // elseif(count($items)<$quantity)
        // {
        //   echo "Out of stock\n";
        // }

        // $items.slice(0, quantity)
        // return array_slice($items, $quantity);
        $item = null;
        $items = $this->items();
        foreach ($items as $struct) {
            if ($number == array_search($number, $items)) {
                $item = $struct;
                return $item;
            }
        }
        // print_r($this->items());
    }

    /**
     * 自身の所有する（自身がオーナーとなっている）全てのItemインスタンスを返します。
     * @return array
     */
    private function items(): array
    {
        return array_filter(
            Item::all(),
            fn($item) => $item->owner === $this
        );
    }

    /**
     * 自身の所有するItemインスタンスの在庫状況を、
     * ["番号", "商品名", "金額", "数量"]という列でテーブル形式にして出力します。
     */
    public function itemsList(): void
    {
        // TODO マルチバイト対応
        echo '+----+------------------+-----+----+' . PHP_EOL;
        printf('|%s|%s|%s|%s|' . PHP_EOL,'番号', '商品名            ', '金額 ', '数量');
        echo '+----+------------------+-----+----+' . PHP_EOL;
        foreach ($this->stock() as $stock)
            printf(
                '|%-4d|%-18s|%5d|%4d|' . PHP_EOL,
                $stock['number'],
                $stock['label']['name'],
                $stock['label']['price'],
                count($stock['items']),
            );
        echo '+----+------------------+-----+----+' . PHP_EOL;
    }

    /**
     * 自身の所有するItemインスタンスの在庫状況を返します。
     * @return array
     */
    function stock(): array
    {
        $groups = $this->groupByLabel(items: $this->items());

        $result = [];
        $index = 0;
        foreach ($groups as $label => $items) {
            $result[] = [
                'number' => $index,
                'label' => json_decode($label, true),
                'items' => $items,
            ];
            $index++;
        }
        return $result;
    }

    /**
     * @param array $items
     * @return array
     */
    private function groupByLabel(array $items): array
    {
        $groups = [];
        foreach ($items as $item) {
            $key = $item->label();
            if (array_key_exists($key, $groups)) {
                $groups[$key][] = $item;
            } else {
                $groups[$key] = [$item];
            }
        }
        return $groups;
    }
}