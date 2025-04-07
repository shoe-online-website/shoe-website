<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepo;
    protected $sizeRepo;
    protected $cateRepo;
    public function __construct(ProductRepositoryInterface $productRepositoryInterface,
                                SizeRepositoryInterface $sizeRepositoryInterface,
                                CategoryRepositoryInterface $categoryRepositoryInterface) {
        $this->productRepo = $productRepositoryInterface;
        $this->sizeRepo = $sizeRepositoryInterface;
        $this->cateRepo = $categoryRepositoryInterface;
    }
    
    public function index() {
        $pageTitle = "Danh sách sản phẩm";
        $products = $this->productRepo->getAll();
        $categories = $this->cateRepo->getAll();
        return view('backend.products.lists', compact('pageTitle', 'products', 'categories'));
    }
    public function create() {
        $pageTitle = "Thêm sản phẩm";
        $sizes = $this->sizeRepo->getAll();
        $categories = $this->cateRepo->getAll();
        return view('backend.products.add', compact('pageTitle', 'sizes', 'categories'));
    }
    public function store(Request $request) {
        $productExist = $this->productRepo->getProductByCode($request->code);
        if($productExist) {
            return back()->withInput()->with('msg', 'Mã sản phẩm đã tồn tại!');
        }
        $product = $this->productRepo->create([
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => str_replace(',', '', $request->price),
            'discount' => $request->discount ?? 0,
            'sale_price' => str_replace(',', '', $request->sale_price) ?? 0,
            'code' => $request->code,
            'image' => $request->gallery[0],
            'gallery' => json_encode($request->gallery),
            'category_id' => $request->category_id,
            'status' => $request->status,
            'description' => $request->description
        ]);
        if(!$product) {
            return back()->withInput()->with('msg', 'Thêm sản phẩm thất bại!');
        }
        $sizes = [];
        foreach($request->sizes as $key => $id) {
            $sizes[$id] = [
                'quantity' => $request->quantity[$key] ?? 0, 
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];
        }
        $this->productRepo->createProductsSizes($product, $sizes);
        return redirect()->route('admin.products.index')->with('msg', 'Thêm thành công sản phẩm '.$product->name.'!');
    }
    public function edit($productId = 0) {
        $product = $this->productRepo->find($productId);
        if(empty($product)){
            abort(404);
        }
        $pageTitle = "Cập nhật sản phẩm";
        $sizes = $this->sizeRepo->getAll();
        $categories = $this->cateRepo->getAll();              
        return view('backend.products.edit', compact('pageTitle', 'sizes', 'categories', 'product'));
    } 
    public function update($productId = 0, Request $request) {
        $product = $this->productRepo->find($productId);
        if(empty($product)) {
            abort(404);
        }
        $this->productRepo->update($productId, [
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => str_replace(',', '', $request->price),
            'discount' => $request->discount,
            'sale_price' => str_replace(',', '', $request->sale_price) ?? 0,
            'code' => $request->code,
            'image' => $request->gallery[0],
            'gallery' => json_encode($request->gallery),
            'category_id' => $request->category_id,
            'status' => $request->status,
            'description' => $request->description
        ]);
        $sizes = [];
        if(!empty($request->sizes)) {
            
            foreach($request->sizes as $key => $id) {
                $sizes[$id] = [
                    'quantity' => $request->quantity[$key] ?? 0, 
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ];
            }
        }
        $this->productRepo->updateProductsSizes($product, $sizes);
        
        return redirect()->route('admin.products.index')->with('msg', 'Cập nhật thành công sản phẩm '.$product->name.'!');
    }
    public function delete($productId = 0) {
        $product = $this->productRepo->find($productId);
        if (!$product) {
            return response()->json(['message' => 'Sản phẩm không tồn tại!'], 404);
        }
        $this->productRepo->deleteProductsSize($product);
        $this->productRepo->delete($product->id);
    
        return response()->json(['message' => 'Xóa thành công!'], 200);
    }
    public function search(Request $request) {
        return ['products' => $this->productRepo->search($request->all())];
    }
    public function getProductSizes(Request $request) {
    
        $product = $this->productRepo->find($request->id);
        if (!$product) {
            return response()->json([
                'message' => 'Sản phẩm không tồn tại!'
            ], 404);
        }
        return response()->json([
            'message' => 'Xem thành công!',
            'sizes' => $this->productRepo->sortSizesByNumber($product)
        ], 200);
    }
    public function checkCode(Request $request) {
        $productCodeExist = $this->productRepo->getProductByCode($request->code);
        if($productCodeExist) {
            return response()->json(['message' => 'Mã sản phẩm đã tồn tại!', 'success' => false], 500);
        }
        return response()->json(['success' => true], 200);
    }
    
}
