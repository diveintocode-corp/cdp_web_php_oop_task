<?php
class Item{
  // attr_reader :name, :price

  // @@instances = []
  // public $this->instances = array(0);
  public static $instances = array();

  function __construct($name, $price, $owner=nil)
  {
      $this->name = $name;
      $this->price = $price;
      $this->owner = $owner;
      // $instances = array();
      # Itemインスタンスの生成時、そのItemインスタンス(self)は、@@insntancesというクラス変数に格納されます。
      // $this->instances << self
      array_push(self::$instances, $this);
  }

  function label(){
    // { name: name, price: price }
    $name ="name";
    $price = "price";
  }

  function all(){
      #　@@instancesを返します ==> Item.allでこれまでに生成されたItemインスタンスを全て返すということです。
      // @@instances
      return self::$instances;
  }

}