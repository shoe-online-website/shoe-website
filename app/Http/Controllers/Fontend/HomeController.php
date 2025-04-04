<?php
namespace App\Http\Controllers\Fontend;

use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    protected $productRepo;
    public function __construct(ProductRepositoryInterface $productRepositoryInterface) {
        $this->productRepo = $productRepositoryInterface;
    }
    
    public function index() {
        $pageTitle = 'Trang chủ';
        $products = $this->productRepo->getProductsHome(24);
        return view('fontend.home', compact('pageTitle', 'products'));
    }

}
