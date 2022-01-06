<?php

declare(strict_types=1);

require_once 'shopping_app/seller.php';
require_once 'shopping_app/item.php';
require_once 'shopping_app/customer.php';

$seller = new Seller(name: 'DICストア');
$items = [];
for ($i = 0; $i < 5; $i++) {
    global $item;
    $item = new Item("CPU", 40830, $seller);
    // $item1 = new Item("PC",40830,$seller);
    $items[] = $item;
    // $items[]=$item1;
}
// 10.times{ Item.new("CPU", 40830, seller) }
// 10.times{ Item.new("メモリー", 13880, seller) }
// 10.times{ Item.new("マザーボード", 28980, seller) }
// 10.times{ Item.new("電源ユニット", 8980, seller) }
// 10.times{ Item.new("PCケース", 8727, seller) }
// 10.times{ Item.new("3.5インチHDD", 10980, seller) }
// 10.times{ Item.new("2.5インチSSD", 13370, seller) }
// 10.times{ Item.new("M.2 SSD", 12980, seller) }
// 10.times{ Item.new("CPUクーラー", 13400, seller) }
// 10.times{ Item.new("グラフィックボード", 23800, seller) }


echo '🤖 あなたの名前を教えてください' . PHP_EOL;
$customer = new Customer(name: readline());

echo '🏧 ウォレットにチャージする金額を入力にしてください' . PHP_EOL;
$customer->wallet->deposit(readline());

echo '🛍️ ショッピングを開始します' . PHP_EOL;
$end_shopping = false;
while (!$end_shopping) {
    echo '📜 商品リスト' . PHP_EOL;
    echo $seller->items_list();
    // print_r($items);

    echo '⛏ 商品数量を入力してください' . PHP_EOL;
    $number = readline();

    echo '⛏ 商品数量を入力してください' . PHP_EOL;
    $quantity = readline();

    $items = $seller->pick_items($number, $quantity);

    // $items->each{|item| customer.cart.add(item) }
    foreach ((array)$items as $item) {
        $customer->cart->add($item);
    }

    echo '🛒 カートの中身' . PHP_EOL;
    $customer->cart->items_list();
    echo '🤑 合計金額:' . $customer->cart->total_amount() . PHP_EOL;

    echo '😭 買い物を終了しますか？(yes/no)' . PHP_EOL;
    $end_shopping = readline() == "yes";
}

echo '💸 購入を確定しますか？(yes/no)' . PHP_EOL;
if (readline() == "yes") {
    $customer->cart->check_out();
}

echo "୨୧┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈Result┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈୨୧" . PHP_EOL;
echo "️🛍️ ️{$customer->name}" . 'の所有物' . PHP_EOL;
$customer->items_list();
echo "😱👛 {$customer->name }のウォレット残高: {$customer->wallet->balance}" . PHP_EOL;

echo "📦 {$seller->name } の在庫状況" . PHP_EOL;
$seller->items_list();
echo "😻👛 {$seller->name }のウォレット残高: {$seller->wallet->balance}" . PHP_EOL;

echo '🛒 カートの中身' . PHP_EOL;
$customer->cart->items_list();
echo "🌚 合計金額: {$customer->cart->total_amount()}" . PHP_EOL;

echo '🎉 終了' . PHP_EOL;
