<?php 
namespace App\Repositories\OrderDetail;

use App\Repositories\RepositoryInterface;
interface OrderDetailRepositoryInterface extends RepositoryInterface{
    public function getOrderDetail($orderId);
}
