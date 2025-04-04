<?php 
namespace App\Repositories\Product;

use App\Repositories\RepositoryInterface;
interface ProductRepositoryInterface extends RepositoryInterface{
    public function createProductsSizes($product, $data = []);
    public function updateProductsSizes($product, $data = []);
    public function deleteProductsSize($product);
    public function sortSizesByNumber($product);
    public function search($inputData);
    public function getProductsByCategoryId($categoryId);
    public function getProductBySlug($slug);
    public function getAllProducts();
    public function searchProductsClient($inputData);
    public function getRelatedProducts($productId, $categoryId);
    public function getNewProducts($categories);
    public function getProductsHome($limit = 1);
}
