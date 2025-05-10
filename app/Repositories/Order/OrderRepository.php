<?php
namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\BaseRepository;
use App\Repositories\Order\OrderRepositoryInterface;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface{
    public function getModel(){
        return Order::class;
    }
    public function getOrders(){
        return $this->model->with(['ordersStatus'])
            ->orderByRaw('CASE WHEN order_status_id = 1 THEN 0 ELSE 1 END')
            ->latest('payment_complete_date')
            ->get();
    }
    public function search($keyword) {
        return $this->model->with(['ordersStatus'])
            ->where('name', 'like', '%'.$keyword.'%')
            ->orWhere('phone', 'like', '%'.$keyword.'%')
            ->orWhere('email', 'like', '%'.$keyword.'%')
            ->get();
    }
    public function getBestSeller(){
        return $this->model
            ->where('order_status_id', 2)
            ->join('orders_detail', 'orders.id', '=', 'orders_detail.order_id')
            ->join('products', 'orders_detail.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                'products.price',
                'products.image',
                'products.discount',
                'products.slug',
                'products.sale_price',
                \DB::raw('SUM(orders_detail.quantity) as total_quantity')
            )
            ->groupBy('products.id', 'products.name', 'products.price', 'products.image', 'products.discount', 'products.slug', 'products.sale_price')
            ->orderBy('total_quantity', 'desc')
            ->take(10) // Lấy top 10 sản phẩm
            ->get();
    }
    public function getTotalPriceOrders(){
        return $this->model->where('order_status_id', 2)->sum('total');
    }
}