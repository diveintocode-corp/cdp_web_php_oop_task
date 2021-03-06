<?php

declare(strict_types=1);

require_once 'shopping_app/seller.php';
require_once 'shopping_app/item.php';
require_once 'shopping_app/customer.php';

$seller = new Seller(name: 'DICในใใข');
createItem(times: 10, name: 'CPU', price: 40830, owner: $seller);
createItem(times: 10, name: 'memory', price: 13880, owner: $seller);
createItem(times: 10, name: 'Motherboard', price: 28980, owner: $seller);
createItem(times: 10, name: 'Power supply unit', price: 8980, owner: $seller);
createItem(times: 10, name: 'PC case', price: 8727, owner: $seller);
createItem(times: 10, name: '3.5 inch HDD', price: 10980, owner: $seller);
createItem(times: 10, name: '2.5 inch SSD', price: 13370, owner: $seller);
createItem(times: 10, name: 'M.2 SSD', price: 12980, owner: $seller);
createItem(times: 10, name: 'CPU cooler', price: 13400, owner: $seller);
createItem(times: 10, name: 'graphic board', price: 23800, owner: $seller);

function createItem(int $times, string $name, int $price, ?User $owner): void
{
    for ($i = 0; $i < $times; $i++) {
        new Item(name: $name, price: $price, owner: $owner);
    }
}

echo '๐ค ใใชใใฎๅๅใๆใใฆใใ ใใ' . PHP_EOL;
$customer = new Customer(name: readline());

echo '๐ง ใฆใฉใฌใใใซใใฃใผใธใใ้้กใๅฅๅใซใใฆใใ ใใ' . PHP_EOL;
$customer->wallet->deposit(amount: intval(readline()));

echo '๐๏ธ ใทใงใใใณใฐใ้ๅงใใพใ' . PHP_EOL;
$end_shopping = false;
while (!$end_shopping) {
    echo '๐ ๅๅใชในใ' . PHP_EOL;
    $seller->itemsList();

    echo 'โ ๅๅ็ชๅทใๅฅๅใใฆใใ ใใ' . PHP_EOL;
    $number = intval(readline());

    echo 'โ ๅๅๆฐ้ใๅฅๅใใฆใใ ใใ' . PHP_EOL;
    $quantity = intval(readline());

    $items = $seller->pickItems(number: $number, quantity: $quantity);

    foreach ($items as $item) {
        $customer->cart->add(item: $item);
    }

    echo '๐ ใซใผใใฎไธญ่บซ' . PHP_EOL;
    $customer->cart->itemsList();
    echo '๐ค ๅ่จ้้ก:' . $customer->cart->totalAmount() . PHP_EOL;

    echo '๐ญ ่ฒทใ็ฉใ็ตไบใใพใใ๏ผ(yes/no)' . PHP_EOL;
    $end_shopping = readline() === 'yes';
}

echo '๐ธ ่ณผๅฅใ็ขบๅฎใใพใใ๏ผ(yes/no)' . PHP_EOL;
if (readline() === 'yes') {
    $customer->cart->checkOut();
}

echo 'เญจเญงโโโโโโโโโโโโโโโโโ็ตๆโโโโโโโโโโโโโโโโโเญจเญง' . PHP_EOL;
echo "๏ธ๐๏ธ ๏ธ{$customer->name}" . 'ใฎๆๆ็ฉ' . PHP_EOL;
$customer->itemsList();
echo "๐ฑ๐ {$customer->name}ใฎใฆใฉใฌใใๆฎ้ซ: {$customer->wallet->balance}" . PHP_EOL;

echo "๐ฆ {$seller->name} ใฎๅจๅบซ็ถๆณ" . PHP_EOL;
$seller->itemsList();
echo "๐ป๐ {$seller->name}ใฎใฆใฉใฌใใๆฎ้ซ: {$seller->wallet->balance}" . PHP_EOL;

echo '๐ ใซใผใใฎไธญ่บซ' . PHP_EOL;
$customer->cart->itemsList();
echo "๐ ๅ่จ้้ก: {$customer->cart->totalAmount()}" . PHP_EOL;

echo '๐ ็ตไบ' . PHP_EOL;
