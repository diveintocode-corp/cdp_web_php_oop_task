<?php

declare(strict_types=1);

include_once 'item.php';

/**
 * このトレイトを読み込むと、自身の所有するItemインスタンスを操れるようになります。
 */
trait ItemManager
{
    /**
     * number と対応した自身の所有する Item インスタンスを指定された quantity 分返します。
     */
    public function pickItems(int $number, int $quantity): array
    {
        $filtered = array_filter($this->stock(), fn($stock) => $stock['number'] === $number);
        $items = reset($filtered) ? reset($filtered)['items'] : null;
        if (!$items || count($items) < $quantity) return [];

        return array_splice($items, 0, $quantity);
    }

    /**
     * 自身の所有するItemインスタンスの在庫状況を返します。
     */
    private function stock(): array
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

    /**
     * 自身の所有する（自身がオーナーとなっている）全てのItemインスタンスを返します。
     */
    private function items(): array
    {
        return array_filter(
            Item::all(),
            fn($item) => $item->owner === $this
        );
    }

    /**
     * 自身の所有するItemインスタンスの在庫状況を、["番号", "商品名", "金額", "数量"]という列でテーブル形式にして出力します。
     */
    public function itemsList(): void
    {
        $header = '|番号|商品名            |金額 |数量|';
        $body = array_map(fn($stock) => sprintf(
            '|%-4d|%-18s|%5d|%4d|' . PHP_EOL,
            $stock['number'],
            $stock['label']['name'],
            $stock['label']['price'],
            count($stock['items']),
        ), $this->stock());
        echo $this->kosi(header: $header, body: $body);
    }

    private function kosi(string $header, array $body): string
    {
        return
            '+----+------------------+-----+----+' . PHP_EOL .
            $header . PHP_EOL .
            '+----+------------------+-----+----+' . PHP_EOL .
            implode($body) .
            '+----+------------------+-----+----+' . PHP_EOL;
    }
}
