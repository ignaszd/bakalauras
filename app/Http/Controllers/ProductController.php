<?php

namespace App\Http\Controllers;
use App\Constants\GlobalConstants;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Cartalyst\Stripe\Api\Charges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::getProducts(GlobalConstants::ALL,GlobalConstants::ALL,GlobalConstants::ALL);
        return view('shop.index')
            ->with('products',$products);
    }

    public function getMoreProducts(Request $request)
    {
        $product = $request->product;
        $brand = $request->brand;
        $size = $request->size;
        if($request->ajax()){
            $products = Product::getProducts($product,$brand,$size);
            return view('shop/includes/products_data',compact('products','brand','size'))->render();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shop.add');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('image'))
        {
            $file=$request->file('image');
            $imageName = time().rand(1,1000).'-image-'.time().rand(1,1000).'.'.$file->extension();
            $file->move('product_images',$imageName);


            $product = Product::create([
                'imagePath' =>$imageName,
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'price'=>$request->input('price'),
                'product' => $request->get('product'),
                'brand' => $request->input('brand'),
                'size' => $request->input('size'),
            ]);

        }

        return redirect('/shop')
            ->with('message', 'Product has been created successfully!');;
    }

    public function getAddToCart(Request $request,$id)
    {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);
        $request->session()->put('cart',$cart);
        return redirect()
            ->back()
            ->with('message','Product has been added to cart successfully!');
    }

    public function getReduceByOne($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);

        if(count($cart->items) > 0){
            Session::put('cart',$cart);
        }
        else{
            Session::forget('cart');
        }
        return redirect()
            ->back()
            ->with('message','Item reduction from cart has been completed successfully!');
    }

    public function getRemoveItem($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);

        if(count($cart->items) > 0){
            Session::put('cart',$cart);
        }
        else{
            Session::forget('cart');
        }

        return redirect()
            ->back()
            ->with('message','Item has been removed from cart successfully!');;
    }

    public function getCart()
    {
        if(!Session::has('cart')){
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart',['products'=>$cart->items, 'totalPrice'=>$cart->totalPrice]);
    }

    public function getCheckout()
    {
        if(!Session::has('cart')){
            return view('shop.shopping-cart');
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        \Stripe\Stripe::setApiKey('sk_test_51KaGgxCc3mCpUx3hDOv7IcaNbnMpUe8dC4eBvMxfHNo3T5YS3cBk0YpPAGAaH6rfALHq6FUWF6td52yZfLbzALMd00YUyIQNBD');


        $payment_intent = \Stripe\PaymentIntent::create([
            'description' => 'Stripe Test Payment',
            'amount' => $total*100,
            'currency' => 'EUR',
            'payment_method_types' => ['card'],
            ]
        );
        $intent = $payment_intent->client_secret;
        $id = $payment_intent->id;

        return view('shop.checkout',['total'=>$total],compact('intent','id'));
    }

    public function postCheckout(Request $request)
    {
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $order = new Order();
        $order->cart = serialize($cart);
        $order->city = $request->input('city');
        $order->address = $request->input('address');
        $order->first_name = $request->input('first_name');
        $order->last_name = $request->input('last_name');
        $order->phone_number = $request->input('phone_number');
        $order->payment_id = $request->input('payment_id');
        $order->phone_number = $request->input('phone_number');
        $order->user_id = Auth::id();
        $order->status = 0;
        Auth::user()->orders()->save($order);

        Session::forget('cart');
        return redirect()->route('shop')->with('message', 'Purchase has been completed successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('shop.show')
            ->with('product',$product);
    }

    public function orderList()
    {
        $orders = Order::all()
            ->sortBy('created_at')
            ->sortBy('status');

        $orders->transform(function ($order,$key){
            $order->cart = unserialize($order->cart);
            return $order;
        });

        return view('shop.ordersList',['orders' => $orders]);
    }

    public function showOrder($id)
    {
        $orders = Order::all()->where('id',$id);

        $orders->transform(function ($order,$key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('shop.showOrder',['orders' => $orders]);
    }

    public function approved($id)
    {
        $order = Order::find($id);
        $order->update([
            'status' => 1,
        ]);
        return redirect()->back();
    }
    public function sent($id)
    {
        $order = Order::find($id);
        $order->update([
            'status' => 2,
        ]);
        return redirect()->back();
    }
}
