<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Constants\GlobalConstants;


class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $fillable = ['imagePath','title','description','price','product','brand','size'];

    public static function getProducts($product,$brand,$size){
        $products = DB::table('products');

        if($product && $product!= GlobalConstants::ALL){
            $products = $products->where('products.product',$product);
        }

        if($brand && $brand != GlobalConstants::ALL){
            $products = $products->where('products.brand',$brand);
        }

        if($size && $size != GlobalConstants::ALL){
            $products = $products->where('products.size',$size);
        }
        return $products->paginate(PER_PAGE_LIMIT);
    }
}
