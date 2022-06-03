<?php

namespace App\Models;

class Cart
{
    public $items=null;
    public $totalItems = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if($oldCart){
            $this->items = $oldCart->items;
            $this->totalItems = $oldCart->totalItems;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }
    public function add($item,$id){
        $storedItem = ['qty'=>0,'price'=> $item->price, 'item'=>$item];
        if($this->items){
            if(array_key_exists($id,$this->items)){
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty']++;
        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalItems++;
        $this->totalPrice += $item->price;
    }

    public function reduceByOne($id){
        $this->items[$id]['qty']--;
        $this->items[$id]['price'] -= $this->items[$id]['item']['price'];
        $this->totalItems--;
        $this->totalPrice -= $this->items[$id]['item']['price'];

        if($this->items[$id]['qty'] <= 0){
            unset($this->items[$id]);
        }
    }

    public function removeItem($id){
        $this->totalItems -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'];
        unset($this->items[$id]);
    }
}
