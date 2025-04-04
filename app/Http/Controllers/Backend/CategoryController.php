<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
    protected $categoryRepo;
    public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface) {
        $this->categoryRepo = $categoryRepositoryInterface;
    }
    
    public function index() {
        $pageTitle = 'Danh sách danh mục';
        $categories = $this->categoryRepo->getAll();
        return view('backend.categories.lists', compact('pageTitle', 'categories'));
    }
    public function store(Request $request) {
        $this->categoryRepo->create([
            'name' => $request->name, 
            'slug' => $request->slug
        ]);
        return ['stt' => 1, 'message' => "Thêm thành công $request->name"];
    }
    public function edit($categoryId = 0) {
        $category = $this->categoryRepo->find($categoryId); 
        return ($category) ? ['data' => $category, 'stt' => 1] : ['stt' => 0];
    }
    public function update(Request $request) {
        $status = $this->categoryRepo->update($request->id,[
            'name' => $request->name, 
            'slug' => $request->slug
        ]);
        return ($status) ? ['stt' => 1, 'message' => "Cập nhật thành công $request->name"] : ['stt' => 0, 'message' => "Lỗi!"];
    }
    public function delete($categoryId = 0) {
        return ($this->categoryRepo->delete($categoryId)) ? ['stt' => 1, 'message' => "Xóa thành công!"] : ['stt' => 0, 'message' => "Lỗi!"];
    }
}
