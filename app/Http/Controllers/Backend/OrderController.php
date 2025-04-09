<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;
use Illuminate\Http\Request;
class OrderController extends Controller
{
    protected $orderRepo;
    protected $orderDetailRepo;
    protected $sizeRepo;
    public function __construct(OrderRepositoryInterface $orderRepositoryInterface, 
        OrderDetailRepositoryInterface $orderDetailRepositoryInterface,
        SizeRepositoryInterface $sizeRepositoryInterface) 
    {
        $this->orderRepo = $orderRepositoryInterface;
        $this->orderDetailRepo = $orderDetailRepositoryInterface;
        $this->sizeRepo = $sizeRepositoryInterface;
    }
    
    public function index() {
        $pageTitle = 'Danh sách đơn hàng';
        $orders = $this->orderRepo->getOrders();
        return view('backend.orders.lists', compact('orders', 'pageTitle'));
    }
    public function detail($orderId) {
        $pageTitle = 'Chi tiết đơn hàng';
        $orderDetails = $this->orderDetailRepo->getOrderDetail($orderId);
        // dd($orderDetails);
        return view('backend.orders.detail', compact('orderDetails', 'pageTitle'));
    }
    public function update(Request $request, $orderId) {
        $orderDetails = $this->orderDetailRepo->getOrderDetail($orderId);
        if(!$orderDetails) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng không tồn tại',
            ]);
        }

        foreach($orderDetails as $item) {
            $product = $item->product;
            $size = $this->sizeRepo->getSizeBySizeNumber($item->size_number);
            $existingPivot = $product->sizes()->where('size_id', $size->id)->first();
            if($existingPivot) {
                $product->sizes()->updateExistingPivot($size->id, [
                    'quantity' => $existingPivot->pivot->quantity - $item->quantity
                ]);
            }
        }
        $this->orderRepo->update($orderId, [
            'order_status_id' => $request->orderStatusId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thành công!',
        ]);
    }
    public function search(Request $request) {
        $orders = $this->orderRepo->search($request->keyword);
        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

}
