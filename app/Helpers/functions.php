<?php

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use Illuminate\Support\Carbon;

function isRoute($routeList) {
    if(!empty($routeList)) {
        foreach($routeList as $route) {
            if(request()->is(trim($route, '/'))) {
                return true;
            }
        }
    }
    return false;
}
function money($number, $currency = 'đ') {
    return $number > 0 ? number_format($number, 0) : 0;
}
function createCoupon() {
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $res = "";
    for ($i = 0; $i < 20; $i++) {
        $res .= $chars[mt_rand(0, strlen($chars)-1)];
    }
    return $res;
}
function getSizes() {
    $sizeRepositoryInterface = app(SizeRepositoryInterface::class);
    return cache()->remember('search_sizes', now()->addHours(2), function () use ($sizeRepositoryInterface) {
        return $sizeRepositoryInterface->getAll();
    }) ?: false;
}
function getCategory() {
    $url = url()->current();
    $split = explode('/', $url);
    if (count($split) === 5) {
        return $split[4];
    }
    return '';
}
function priceRangeArr() {
    return cache()->remember('search_price', now()->addHours(2), function (){
        return [
            'Dưới 2 triệu' => '0-2000000',
            'Từ 2 triệu đến 5 triệu' => '2000000-5000000',
            'Từ 5 triệu đến 10 triệu' => '5000000-10000000',
            'Từ 10 triệu đến 15 triệu' => '10000000-15000000',
            'Trên 15 triệu' => '15000000-0',
        ];
    }) ?: false;

}
function sortArr() {
    return cache()->remember('search_sort', now()->addHours(2), function (){
        return [
            'Giá thấp đến cao' => 'price_asc',
            'Giá cao đến thấp' => 'price_desc',
            'Tên A - Z' => 'name_asc',
            'Tên Z - A' => 'name_desc'
        ];
    }) ?: false;
}
function getTextSearchArr() {
    $keyword = request('keyword');
    if($keyword) {
        return false;
    }
    $categorySlug = request('categorySlug');
    $listSize = request('listSize');
    $priceRange = request('priceRange');
    $sort = request('sort');
    $priceRangeText = null;
    if($priceRange) {
        [ $min, $max ] = explode('-', $priceRange);
        $min = $min / 1000000;
        $max = $max / 1000000;
        $min = round($min);
        $max = round($max);
        if($min == 0) {
            $priceRangeText = 'Dưới '.$max.' triệu';
        } else if($max == 0) {
            $priceRangeText = 'Từ '.$min.' triệu trở lên';
        } else {
            $priceRangeText = 'Từ '.$min.' đến '.$max.' triệu';
        }
    }
    return [
        'sản phẩm' => $categorySlug,
        'size' => $listSize,
        'giá' => $priceRangeText
    ];
 
}
function getTag() {
    $categoryRepositoryInterface = app(CategoryRepositoryInterface::class);

    return cache()->remember('search_categories', now()->addHours(2), function () use ($categoryRepositoryInterface) {
        return $categoryRepositoryInterface->getAll();
    }) ?: false;
}
function getRelatedProducts($productId, $categoryId) {
    $productRepositoryInterface = app(ProductRepositoryInterface::class);
    return $productRepositoryInterface->getRelatedProducts($productId, $categoryId);
}
function getNewProducts() {
    $productRepositoryInterface = app(ProductRepositoryInterface::class);
    $categoryRepositoryInterface = app(CategoryRepositoryInterface::class);
    return $productRepositoryInterface->getNewProducts($categoryRepositoryInterface->getAll());
}