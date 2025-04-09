<?php 
namespace App\Repositories\Order;

use App\Repositories\RepositoryInterface;
interface OrderRepositoryInterface extends RepositoryInterface{
    public function getOrders();
    public function search($keyword);
    public function getBestSeller();
    public function getTotalPriceOrders();
}
