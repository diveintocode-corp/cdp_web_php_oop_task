<?php
require_once "shopping_app/seller.php";
require_once "shopping_app/item.php";
require_once "shopping_app/customer.php";

$seller = new Seller("DICストア");
$items = [];
for($i=0;$i<5;$i++){
  global $item;
  $item = new Item("CPU",40830,$seller);
  // $item1 = new Item("PC",40830,$seller);
  $items[]=$item;
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


echo "🤖 Please tell me your name\n";
$customer =new Customer(readline());

echo "🏧 Please enter the amount to be charged to the wallet\n";
$customer->wallet->deposit(readline());

echo "🛍️ Start shopping\n";
$end_shopping = false;
while (!$end_shopping) {
  echo "📜 Product List\n";
  echo $seller->items_list();
  // print_r($items);

  echo "️️⛏ Please enter the item number\n";
  $number = readline();

  echo "⛏ Please enter the item quantity\n";
  $quantity = readline();

  $items = $seller->pick_items($number, $quantity);

  // $items->each{|item| customer.cart.add(item) }
  foreach((array)$items as $item){
    $customer->cart->add($item);
  }

  echo "🛒 The contents of the cart\n";
  $customer->cart->items_list();
  echo "🤑 total fee: {$customer->cart->total_amount()}\n";

  echo "😭 Do you want to finish shopping?(yes/no)\n";
  $end_shopping = readline() == "yes";
}

echo "💸 Do you want to confirm your purchase?(yes/no)\n";
if(readline()=="yes")
{
  $customer->cart->check_out();
}

echo "୨୧┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈Result┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈୨୧\n";
echo "️🛍️ ️{$customer->name}Property\n";
$customer->items_list();
echo "😱👛 {$customer->name } Wallet balance: {$customer->wallet->balance}\n";

echo "📦 {$seller->name } Stock status\n";
$seller->items_list();
echo "😻👛 {$seller->name } Wallet balance: {$seller->wallet->balance}\n";

echo "🛒 The contents of the cart\n";
$customer->cart->items_list();
echo "🌚 total fee: {$customer->cart->total_amount()}\n";

echo "🎉 end\n";
?>