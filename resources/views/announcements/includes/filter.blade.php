<div style="margin-bottom: 20px;margin-top: 20px">
    <form>
         <div class="row mt-1 d-md-flex align-items-end">
             <div class="form-group col-lg-3 px-md-2 pb-2 ">
                 <b><label for="product">Select product type:</label></b>
                 <select class="form-select" id="product">
                     <option selected>{{App\Constants\GlobalConstants::ALL}}</option>
                     @foreach(App\Constants\GlobalConstants::LIST_PRODUCTS as $product)
                         <option value="{{$product}}">{{$product}}</option>
                     @endforeach
                 </select>
             </div>
             <div class="form-group col-lg-3 px-md-2 pt-md-2 mt-lg-0 pb-2 ">
                 <b><label for="brand">Select product brand:</label></b>
                 <select class="form-select" id="brand" style="overflow: hidden">
                     <option selected>{{App\Constants\GlobalConstants::ALL}}</option>
                     @foreach(App\Constants\GlobalConstants::LIST_BRANDS as $brand)
                         <option value="{{$brand}}">{{$brand}}</option>
                     @endforeach
                 </select>
             </div>
             <div class="form-group col-lg-3 px-md-2 pt-md-2 mt-lg-0 pb-2 ">
                 <b><label for="size">Select product size:</label></b>
                 <select class="form-select" id="size">
                     <option selected>{{App\Constants\GlobalConstants::ALL}}</option>
                     @foreach(App\Constants\GlobalConstants::LIST_SIZES as $size)
                         <option value="{{$size}}">{{$size}}</option>
                     @endforeach
                 </select>
             </div>
             <div class="form-group col-lg-3 px-md-2 pt-md-2 mt-lg-0 pb-2 ">
                 <button id="reset" style="margin-left: 8rem" class="btn btn-primary">Reset filters</button>
             </div>
             @isset($shop)
                 @can('is-owner')
                     <div class="form-group col-lg-3 px-md-2 pt-md-2 mt-lg-0 pb-2 ">
                         <a href="{{route('addProduct')}}" class="btn btn-success">Add new product</a>
                         <a href="{{route('shop.getOrdersList')}}" class="btn btn-success">Order list</a>
                     </div>
                 @endcan
             @endisset
             @isset($announcements)
                 @can('hasAnyRoles')
                     <div class="form-group col-lg-5 px-md-2 pt-md-2 mt-lg-0 pb-2 ">
                         <a href="{{route('announcements.create')}}" class="btn btn-success"> Create announcement</a>
                         <a href="{{route('announcements.manage')}}" class="btn btn-success"> Manage created announcements</a>
                     </div>
                 @endcan
             @endisset
         </div>
     </form>
</div>

