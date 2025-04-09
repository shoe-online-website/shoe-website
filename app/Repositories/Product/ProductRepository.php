<?php
namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface{
    public function getModel(){
        return Product::class;
    }
    public function createProductsSizes($product, $data = []){
        return $product->sizes()->attach($data);
    }
    public function updateProductsSizes($product, $data = []) {
        return $product->sizes()->sync($data);
    }
    public function deleteProductsSize($product) {
        return $product->sizes()->detach();
    }
    public function sortSizesByNumber($product){
        return $product->sizes()->orderBy('size_number', 'asc')->get();
    }
    public function search($inputData){
        return 
        $this->model
            ->when(($inputData['keyword'] != null), function ($query) use ($inputData) {
                return $query->where('name', 'like', '%'.$inputData['keyword'].'%')->orWhere('code', 'like', '%'.$inputData['keyword'].'%');
            })
            ->when(($inputData['status'] != null), function ($query) use ($inputData) {
                return $query->where('status', $inputData['status']);
            })
            ->when(($inputData['category_id'] != null), function ($query) use ($inputData) {
                return $query->whereHas('category', function ($subQuery) use ($inputData) {
                    return $subQuery->where('id', $inputData['category_id']);
                });
            })
        ->with('category')
        ->latest('created_at')
        ->get();
    }
    public function getProductsByCategoryId($categoryId) {
        return $this->model
                ->where('category_id', $categoryId)
                ->latest('created_at')
                ->get();
    }
    public function getProductBySlug($slug) {
        return $this->model
                ->where('slug', $slug)
                ->first();
    }
    public function getAllProducts() {
        return $this->model->where('status', 1)->latest('created_at')->get();
    }
    public function searchProductsClient($inputData) {
        return $this->model->where('status', 1)
            ->when(!empty($inputData['keyword']), function ($query) use ($inputData) {
                return $query->where(function ($subQuery) use ($inputData) {
                    return $subQuery->where('name', 'like', '%'.$inputData['keyword'].'%')
                        ->orwhere('code', 'like', '%'.$inputData['keyword'].'%');
                });
            })
            ->when(!empty($inputData['categorySlug']), function ($query) use ($inputData) {
                return $query->whereHas('category', function ($subQuery) use ($inputData) {
                    return $subQuery->where('slug', $inputData['categorySlug']);
                });
            })
            ->when(!empty($inputData['listSize']), function ($query) use ($inputData) {
                return $query->whereHas('sizes', function ($subQuery) use ($inputData) {
                    return $subQuery->where('size_number', $inputData['listSize']);
                });
            })
            ->when(!empty($inputData['priceRange']), function ($query) use ($inputData) {
                [$min, $max] = explode('-', $inputData['priceRange']);
                if($max == 0) {
                    return $query->where('price', '>=', $min);
                }
                return $query->whereBetween('price', [$min, $max]);
            })
            ->when(!empty($inputData['sort']), function ($query) use ($inputData) {
                [$name, $direction] = explode('_', $inputData['sort']);
                return $query->orderBy($name, $direction);
            })
            ->with('category', 'sizes')
            ->latest('created_at')
            ->get();
    }
    public function getRelatedProducts($productId, $categoryId) {
        $randomIds = $this->model->where('status', 1)
            ->where('id', '!=', $productId)
            ->where('category_id', $categoryId)
            ->pluck('id') // Lấy danh sách ID
            ->shuffle() // Trộn ngẫu nhiên danh sách
            ->take(10); // Lấy 10 ID ngẫu nhiên
    
        return $this->model->whereIn('id', $randomIds)->get();
    }
    public function getNewProducts($categories) {
        if (empty($categories)) {
            return false;
        }
    
        $products = [];
        foreach ($categories as $category) {
            $product = $this->model
                ->select('id', 'name', 'slug', 'price', 'discount', 'sale_price', 'image')
                ->where('status', 1)
                ->where('category_id', $category->id)
                ->latest('created_at')
                ->first();
    
            if ($product) {
                $products[] = $product; // Không cần key
            }
        }
    
        return $products;
    }
    public function getProductsHome($limit = 1) {
        return $this->model->where('status', 1)
            ->latest('created_at')
            ->orderBy('name', 'desc')
            ->paginate($limit);
    }
    public function getProductByCode($code) {
        return $this->model->where('code', $code)->first();
    }
    public function getProductByName($name) {
        return $this->model->where('name', $name)->first();
    }
    

}