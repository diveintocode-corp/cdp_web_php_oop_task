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

    public function items()
    { # 自身の所有する（自身がオーナーとなっている）全てのItemインスタンスを返します。
        // return Item->all->select{|item| item.owner == self }
        // return array_filter(Item::all(), $this);
        // $items = [];
        return Item::all();
        // $items= Item::all-select('owner','=',$this);

        // return $items;
        // foreach (Item::all() as $item) {
        //   if($item->owner == $this){
        //     return $item;
        //     // return array_filter(array_column($item, $this));
        //   }
        // }
    }

    public function itemsList()
    { # 自身の所有するItemインスタンスの在庫状況を、["番号", "商品名", "金額", "数量"]という列でテーブル形式にして出力します。
        // print_r(
        // stock.map do |stock|

        // foreach ((array)$this->stock() as $stock) {
        $i = 0;
        foreach ((array)$this->items() as $stock) {
            if (is_object($stock)) {
                //     print_r([
                //   "番号: "{ $stock[$number]},
                //   "商品名: "{$stock[$label][$name]},
                //   "金額: "{ $stock[$label][$price]},
                //   "数量: "{ $stock[count($items)]}
                // ]);
                echo "number: " . $i . "  ";
                echo "Product name: " . $stock->name . "  ";
                echo "Amount of money: " . $stock->price . "  ";
                // echo "quantity: ".count((array)$this->items())."  ";
                echo "quantity: " . count((array)$this->stock()) . "  ";
                echo "\n";
                $i++;
            }
        }
        // return $items;
        // print_r((array)$this->items());
    }


    function stock()
    { # 自身の所有するItemインスタンスの在庫状況を返します。
        //   $items
        //     .group_by{|item| item.label } # Item#labelで同じ値を返すItemインスタンスで分類します。
        //     .map.with_index do |label_and_items, index|
        //       {
        //         number: index,
        //         label: {
        //           name: label_and_items[0][:name],
        //           price: label_and_items[0][:price],
        //         },
        //         items: label_and_items[1], # このitemsの中に、分類されたItemインスタンスを格納します。
        //       }
        //     end
        // end

        //     }

        //     $group = array();
        $i = 0;
        $items = $this->items();
        $result = array();
        foreach ($items as $value) {
            if (is_object($value)) {
                // name: $value[0][$name];
                $result['number'] = $i;
                $result['name'] = $value->name;
                $result['price'] = $value->price;
                // price: $value[0][$price];
                $i++;
            }
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