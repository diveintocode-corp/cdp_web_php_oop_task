<?php

include_once "item_manager.php";

class Cart{
  use ItemManager;

  function __construct($owner)
  {
      $this->owner = $owner;
      $this->items = [];
  }

  function items(){
    # Cartにとってのitemsは自身の@itemsとしたいため、ItemManagerのitemsメソッドをオーバーライドします。
    # CartインスタンスがItemインスタンスを持つときは、オーナー権限の移譲をさせることなく、自身の@itemsに格納(Cart#add)するだけだからです。
    $this->items;
  }

  function add($item)
  {
      // @items << item
      array_push($this->items, $item);
  }

  function total_amount(){
    // $this->items->sum(&:price);
    return array_sum($this->items);
  }

  function check_out(){
    if ($this->owner->wallet->balance < $this->total_amount()){
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

}
