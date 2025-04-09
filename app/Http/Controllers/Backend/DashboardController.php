<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    protected $orderRepo;
    public function __construct(OrderRepositoryInterface $orderRepositoryInterface) {
        $this->orderRepo = $orderRepositoryInterface;
    }
    
    public function index() {
        $pageTitle = "Dashboard";
        $orders = $this->orderRepo->getBestSeller();
        $totalPriceOrders = $this->orderRepo->getTotalPriceOrders();
        return view('backend.dashboard.lists', compact('pageTitle', 'orders', 'totalPriceOrders'));
    }
}
