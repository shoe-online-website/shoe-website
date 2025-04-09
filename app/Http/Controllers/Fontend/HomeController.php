<?php
namespace App\Http\Controllers\Fontend;

use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    protected $productRepo;
    protected $orderRepo;
    public function __construct(ProductRepositoryInterface $productRepositoryInterface, OrderRepositoryInterface $orderRepositoryInterface) {
        $this->productRepo = $productRepositoryInterface;
        $this->orderRepo = $orderRepositoryInterface;
    }
    
    public function index() {
        $pageTitle = 'Trang chủ';
        $products = $this->productRepo->getProductsHome(24);
        $bestSeller = $this->orderRepo->getBestSeller();
        return view('fontend.home', compact('pageTitle', 'products', 'bestSeller'));
    }

}
