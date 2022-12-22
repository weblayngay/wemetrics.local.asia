<?php
namespace App\Helpers;

use App\Models\Config;
use App\Models\Product;
use Illuminate\Support\Str;

class HtmlHelper
{
    /**
     * @param $cart
     * @return string
     */
    static function htmlList($cart)
    {
        $html = '';

        if (!empty($cart) && count($cart) > 0) {
            foreach ($cart as $key => $item) {

                $sizeId = !empty($item['sizeId']) ? $item['sizeId'] : 0;
                $colorId = !empty($item['colorId']) ? $item['colorId'] : 0;

                $size = \App\Models\ProductSize::query()->where('psize_id', $sizeId)->first();
                $color = \App\Models\ProductColor::query()->where('pcolor_id', $colorId)->first();

                $sizeCode = !empty($size) ? $size->psize_code : '';
                $colorCode = !empty($color) ? $color->pcolor_code : '';

                $html .= '
                <tr>
                    <td class="raavin-product-remove"><a href="#" data-id="' . $item['id'] . '"><i class="fa fa-times"></i></a></td>
                    <td class="raavin-product-thumbnail"><a href=""><img src="' . $item['image'] . '" alt="" style="width: 90px;"></a></td>';


                if($item['type'] == 'shoes'){
                    $html .= '<td class="raavin-product-name"><a href="#">' . $item['name'] .' ('. $colorCode .'-'. $sizeCode .') ' . '</a></td>';
                }else{
                    $html .= '<td class="raavin-product-name"><a href="#">' . $item['name'] . '</a></td>';
                }


                $html .= '<td class="raavin-product-price"><span class="amount">' . $item['price'] . '</span></td>
                    <td class="raavin-product-quantity">
                        <input class="input-text qty text" min="1" name="quantity" data-id="' . $item['id'] . '" value="' . $item['quantity'] . '" title="Qty" size="" type="number">
                    </td>
                    <td class="product-subtotal"><span class="amount">' . $item['sub_total_price'] . '</span></td>
                </tr>
                ';
            }
        }

        return $html;
    }

    /**
     * @param $cart
     * @param $totalPrice
     * @param $total
     * @return string
     */
    static function htmlListHeader($cart, $totalPrice, $total){
        $html = '';

        if (!empty($cart) && count($cart) > 0) {
            $i = 1;
            foreach ($cart as $key => $item) {
                $i++;
                $html .= '
                        <div class="cart-item">
                            <div class="cart-img">
                                <a href="#">
                                    <img style="width: 80px;" src="'. $item['image'] .'" alt="">
                                </a>
                            </div>
                            <div class="cart-info">
                                <div class="pro-item">
                                    <span class="quantity-formated">' .$item['quantity'] .' x</span>
                                    <a class="pro-name" href="#" title="">' .$item['name'] .'</a>
                                </div>
                                <div class="pro-price">
                                    <span>'. $item['price'] .'</span>
                                </div>
                                <div class="remove-link raavin-product-remove">
                                    <a data-id="' .$item['id'] .'" href="#" title="Remove this product from my cart"></a>
                                </div>
                            </div>
                        </div>

                ';
                if ($i == 3){

                    $html .= '
                            <div class="cart-btn">
                                <a class="links links-3" href="'. route('shopping-cart') .'">Xem thêm</a>
                            </div>';
                    break;
                }
            }
        }

        $html .= '<div class="cart-inner-bottom">
                        <div class="cart-shipping cart-item">
                            <div class="total">
                                <span>Tạm tính</span>
                                <span class="amount"> ' .ProductHelper::formatMoney($totalPrice). '</span>
                            </div>
                            <div class="total">
                                <span>Tổng tiền</span>
                                <span class="amount">' .ProductHelper::formatMoney($totalPrice). '</span>
                            </div>
                        </div>
                        <div class="cart-btn">
                            <a class="links links-3" href="'. route('checkout').'">Thanh Toán</a>
                        </div>
                    </div>';

        return $html;
    }


    /**
     * @param $totalPrice
     * @param $total
     */
    static function htmlTotal($totalPrice, $total)
    {
        $route =  route('checkout') ;
        $html = '
            <!--<h2>Cart totals</h2>-->
            <ul>
                <li>Tạm tính <span>' . number_format($totalPrice) . '</span></li>
                <li>Thành tiền <span>' . number_format($total) . '</span></li>
            </ul>
            <a href="'.$route.'">Tiến hành đặt hàng</a>
        ';

        return $html;
    }

    /**
     * @param $cart
     * @return string
     */
    static function htmlListWish($wish)
    {
        $html = '';
        $products = Product::query()->whereIn('product_id', $wish)->get();

        if (!empty($products) && count($products) > 0) {
            foreach ($products as $key => $item) {
                $price = !empty($item->product_new_price) ? $item->product_new_price : $item->product_price - $item->product_discount;
                $pathAvatar = config('my.path.image_product_avatar_of_module');
                $urlAvatar = !empty($item->avatar) ? $pathAvatar . $item->avatar->image_name : '';

                $status = $item->product_status == 'stocking' ? 'Còn Hàng' : 'Hết Hàng';
                $html .= '<tr>
                            <td class="raavin-product-remove-wish-list"><a href="#" data-id="'. $item->product_id .'"><i class="fa fa-times"></i></a></td>
                            <td class="raavin-product-thumbnail"><a href="'.route('detailProduct', ['slug' => Str::slug($item->product_name), 'type' => $item->product_type, 'id' => $item->product_id]) .'"><img src="'. $urlAvatar .'" style="width: 90px;" alt=""></a></td>
                            <td class="raavin-product-name"><a href="'. route('detailProduct', ['slug' => Str::slug($item->product_name), 'type' => $item->product_type, 'id' => $item->product_id]) .'">'. $item->product_name .'</a></td>
                            <td class="raavin-product-price"><span class="amount">'. number_format($price, 0, ' . ', ',') .' đ</span></td>
                            <td class="raavin-product-stock-status"><span class="in-stock">' .$status .'</span></td>
                            <td class="raavin-product-add-cart">
                                <input class="qty" type="hidden" value="1">
                                <a class="add-to-cart" href="' .route('add-cart') .'" data-id="'. $item->product_id .'">Thêm</a>
                            </td>
                        </tr>';

            }
        }

        return $html;
    }

    static function htmlModal($product){
        $html = '';

        $pathAvatar = config('my.path.image_product_avatar_of_module');
        $pathThumbnail = config('my.path.image_product_thumbnail_of_module');
        $pathBanner = config('my.path.image_product_banner_of_module');

        $imageAvatar = $product->avatar;
        $imageThumbnail = $product->thumbnail()->get();
        $imageBanner = $product->banner()->get();

        $configPhone = Config::query()->where('conf_key', 'phone_number')->first();
        $phone = $configPhone->conf_value;
        $price = number_format($product->price, 0, '.', ',');

        if($product->product_type == 'shoes'){
            $colors = $product->colors;
            $sizes = $product->sizes;
        }

        $html .= '
                <div class="col-md-5">
                    <div class="tab-content product-details-large myTabContent">';


        if(!empty($imageBanner) && $imageBanner->count() > 0){
            foreach ($imageBanner as $key => $item){
                $text = '';
                if($key == 0){
                    $text = ' show active ';
                }

                $tmp = $key++;
                $html .= '
                        <div id="single-slide-'.$tmp.'" class="tab-pane fade single-slide'.$tmp.$text.'" role="tabpanel" aria-label="single-slide-tab-'.$tmp.'">
                            <div class="single-product-img img-full">
                                <img src="'.$pathBanner.$item->image_name.'">
                            </div>
                        </div>';
            }
        }


        $html .= '</div>
                    <div class="single-product-menu">
                        <div class="nav single-slide-menu owl-carousel" role="tablist">';

        if(!empty($imageThumbnail) && $imageThumbnail->count() > 0){
            foreach ($imageThumbnail as $key => $item){
                $text = '';
                if($key == 0){
                    $text = ' active ';
                }
                $tmp = $key++;
                $html .= '
                        <div class="single-tab-menu img-full">
                            <a class="'.$text.' single-slide-tab-1" data-toggle="tab" href="#single-slide-'.$tmp.'"><img style="width:90px;" src="'.$pathThumbnail.$item->image_name.'"></a>
                        </div>';
            }
        }

        $html .= '    </div>
                    </div>
                </div>';


        $html .= '
                <div class="col-md-7">
                    <div class="modal-product-info">
                        <h1>'. $product->product_name .'</h1>
                        <div class="rating-2">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="clearfix"></div>
                        <div class="modal-product-price">
                           <span class="new-price">'. $price .' đ</span>
                       </div>
                       <div class="cart-description">
                           '. $product->product_short_description .'
                       </div>';




            if($product->product_type == 'shoes'){

                $html .= '<div class="category mt-15">
                            <h4>Màu sắc</h4>
                            <div class="category-list">';

                if(!empty($colors) && count($colors) > 0){
                    $html .= '<input type="hidden" value="{{ $colors->first()->pcolor_id }}" name="colorId" id="colorId">';

                foreach($colors as $key => $item){
                    $class = $key == 0 ? 'color-active' : '';

                    $html .= '<label data-id="'.$item->pcolor_id.'" class="select-product-color '.$class.'" style="cursor:pointer; padding: 5px; border-radius: 100%; border: 1px solid #d4d4d4; background-color: #f8f9fa">
                            <span style="border-radius: 100%;width: 25px; height: 25px; display: inline-block; background-color: '. $item->pcolor_hex .'"></span>
                        </label>';
                    }
            }
            $html .= ' </div>
                            </div>';

            $html .= '<div class="category mt-15 mb-15">
                        <h4>Kích cỡ</h4>
                        <div class="category-list">';
            if(!empty($sizes) && count($sizes) > 0){

                $html .= '<input type="hidden" value="'.$sizes->first()->psize_id .'" name="sizeId" id="sizeId">';

                foreach($sizes as $key => $item){
                    $class = $key == 0 ? 'size-active' : '';

                    $html .= '<label data-id="'. $item->psize_id .'" class="select-product-size '.$class.'" style=" box-shadow: 3px 3px 9px rgb(0 0 0 / 9%); text-align:center; width: 40px; color: #5b5c6e; cursor:pointer; padding: 5px; border: 1px solid #e7e7e7; background-color: #fff">
                            '. $item->psize_code .'
                        </label>';
                    }
            }
            $html .= '</div>
                </div>';
            }


            $html .= '<form class="pro-details-cart" action="#" method="post">
                        <div class="quantity">
                            <input class="input-text qtyQuick text" min="1" value="1" type="number" style="height: 100%;">
                        </div>';


            if($product->product_status == 'stocking') {
                $html .= '<div class="qty-cart-btn add-to-cart-quick" data-type="' . $product->product_type . '" data-id="' . $product->product_id . '">
                            <a href="#">Thêm vào giỏ hàng</a>
                        </div>';
            }else{
                $html .= '<div class="qty-cart-btn">
                            <a href="tel: '. $phone .'">Liên hệ cửa hàng: ' .$phone . '</a>
                        </div>';
            }



        $html .='       <div class="product-meta">
                            <p>
                                Chủng loại:
                                <a href="#"> '.$product->pcatName .'</a>
                            </p>
                        </div>
                    </div>
                </div>';




        return $html;

    }
}
