<?php
namespace App\Http\Controllers\Fontend;

use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
class ProductController extends Controller
{   
    protected $cateRepo;
    protected $productRepo;
    protected $sizeRepo;
    public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface,
                                ProductRepositoryInterface $productRepositoryInterface,
                                SizeRepositoryInterface $sizeRepositoryInterface) {
        $this->cateRepo = $categoryRepositoryInterface;
        $this->productRepo = $productRepositoryInterface;
        $this->sizeRepo = $sizeRepositoryInterface;
    }
    
    public function index($categorySlug = null) {
        if(!$categorySlug) {
            $pageTitle = 'Danh sách giày';
            $products = $this->productRepo->getAllProducts();
            return view('fontend.products.all_products', compact('pageTitle', 'products'));
        }
        $category = $this->cateRepo->getCategoriesBySlug($categorySlug);
        if(!$category) {
            abort(404);
        }
        $categoryName = $category->name;
        $pageTitle = 'Giày '.$categoryName;
        $products = $this->productRepo->getProductsByCategoryId($category->id);
        return view('fontend.products.index', compact('pageTitle', 'products', 'category'));
    }
    public function detail($slug) {
        $product = $this->productRepo->getProductBySlug($slug);
        if(!$product) {
            abort(404);
        }
        $pageTitle = 'Giày '.$product->name;
        $sizes = $this->productRepo->sortSizesByNumber($product);
        $gallery = json_decode($product->gallery);
        return view('fontend.products.detail', compact('pageTitle', 'product', 'sizes', 'gallery'));
    }
    public function search(Request $request) {
        $inputData = $request->except('_token');
        $pageTitle = 'Kết quả tìm kiếm';
        $products  = $this->productRepo->searchProductsClient($inputData);
        return view('fontend.products.search_products', compact('pageTitle', 'products'));
    }
    public function showSuggestions(Request $request) {
        try {
            $products = $this->productRepo->searchProductsClient($request->all());
            if($products->isEmpty()) {
                throw new Exception('Không tìm thấy sản phẩm', 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Verify success',
                'products' => $products
            ], 200);
        } catch (\Exception $exception) {
            $status = $exception->getCode();
            return response()->json([
                'success' => false,
                'message' => 'Verify failure',
                'errors' => $exception->getMessage()
            ],$status ?? 500 );
        }
    }
}
