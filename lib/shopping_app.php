<?php

declare(strict_types=1);

require_once 'shopping_app/seller.php';
require_once 'shopping_app/item.php';
require_once 'shopping_app/customer.php';

$seller = new Seller(name: 'DICストア');
createItem(times: 10, name: 'CPU', price: 40830, owner: $seller);
createItem(times: 10, name: 'メモリー', price: 13880, owner: $seller);
createItem(times: 10, name: 'マザーボード', price: 28980, owner: $seller);
createItem(times: 10, name: '電源ユニット', price: 8980, owner: $seller);
createItem(times: 10, name: 'PCケース', price: 8727, owner: $seller);
createItem(times: 10, name: '3.5インチHDD', price: 10980, owner: $seller);
createItem(times: 10, name: '2.5インチSSD', price: 13370, owner: $seller);
createItem(times: 10, name: 'M.2 SSD', price: 12980, owner: $seller);
createItem(times: 10, name: 'CPUクーラー', price: 13400, owner: $seller);
createItem(times: 10, name: 'グラフィックボード', price: 23800, owner: $seller);

/**
 * @param int $times
 * @param string $name
 * @param int $price
 * @param User|null $owner
 */
function createItem(int $times, string $name, int $price, ?User $owner): void
{
    for ($i = 0; $i < $times; $i++) {
        new Item(name: $name, price: $price, owner: $owner);
    }
}

echo '🤖 あなたの名前を教えてください' . PHP_EOL;
$customer = new Customer(name: readline());

echo '🏧 ウォレットにチャージする金額を入力にしてください' . PHP_EOL;
$customer->wallet->deposit(amount: intval(readline()));

echo '🛍️ ショッピングを開始します' . PHP_EOL;
$end_shopping = false;
while (!$end_shopping) {
    echo '📜 商品リスト' . PHP_EOL;
    echo $seller->itemsList();
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
    $customer->cart->itemsList();
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
$customer->itemsList();
echo "😱👛 {$customer->name }のウォレット残高: {$customer->wallet->balance}" . PHP_EOL;

echo "📦 {$seller->name } の在庫状況" . PHP_EOL;
$seller->itemsList();
echo "😻👛 {$seller->name }のウォレット残高: {$seller->wallet->balance}" . PHP_EOL;

echo '🛒 カートの中身' . PHP_EOL;
$customer->cart->itemsList();
echo "🌚 合計金額: {$customer->cart->total_amount()}" . PHP_EOL;

echo '🎉 終了' . PHP_EOL;
