<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userRepo;
    public function __construct(UserRepositoryInterface $userRepositoryInterface) {
        $this->userRepo = $userRepositoryInterface;
    }
    
    public function index() {
        $pageTitle = "Danh sách người dùng";
        $users = $this->userRepo->getUsers(1);
        return view('backend.users.lists', compact('pageTitle', 'users'));
    }
    public function create() {
        $pageTitle = "Danh sách người dùng";
        return view('backend.users.add', compact('pageTitle'));
    }
    public function store(Request $request) {
        $inputData = $request->except('_token');
        $rows = [];
        foreach($inputData as $key => $value) {
            
            if(strpos($key, 'row_') !== false) {
                $parts = explode('_', $key);
                $rowIndex = $parts[1];
                $colIndex = $parts[3];
            }
            $rows[$rowIndex][$colIndex] = $value;
        }
        $count = 0;
        foreach($rows as $row) {
            $count++;
            $this->userRepo->create([
                'name' => $row[0],
                'email' => $row[1],
                'phone' => $row[2],
                'password' => Hash::make($row[3]),
                'is_admin' => true
            ]);
        }
        return redirect()->route('admin.users.index')->with('msg', 'Thêm thành công '.$count.' người dùng!');
    } 
    public function edit($userId = 0) {
        $pageTitle = "Cập nhật người dùng";
        $user = $this->userRepo->find($userId);
        if(!$user) {
            abort(404);
        }
        return view('backend.users.edit', compact('pageTitle', 'user'));
    }
    public function update($userId = 0, Request $request) {
        $user = $this->userRepo->find($userId);
        if(!$user) {
            abort(404);
        }
        $inputData = $request->except('_token', 'password');
        if(!empty($request->password)) {
            $inputData['password'] = Hash::make($request->password);
        }
        $this->userRepo->update($user->id, $inputData);
        return back()->with('msg', 'Cập nhật thành công!');
    }
    public function delete($userId = 0, Request $request) {
        $user = $this->userRepo->find($userId);
        if (!$user) {
            return response()->json(['message' => 'Người dùng không tồn tại!'], 404);
        }
        $this->userRepo->delete($user->id);
        return response()->json(['message' => 'Xóa thành công!'], 200);
    }
    public function search(Request $request) {
        return response()->json(['users' => $this->userRepo->search($request->keyword)]);
    }
}
