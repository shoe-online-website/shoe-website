<?php
namespace App\Http\Controllers\Fontend;

use App\Http\Controllers\Controller;
use App\Repositories\Coupon\CouponRepositoryInterface;
use App\Repositories\District\DistrictRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;
use App\Repositories\Province\ProvinceRepositoryInterface;
use App\Repositories\Ward\WardRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
class CheckoutController extends Controller
{
    protected $provinceRepo;
    protected $districtRepo;
    protected $wardRepo;
    protected $couponRepo;
    protected $orderRepo;
    protected $orderDetailRepo;
    public function __construct(ProvinceRepositoryInterface $provinceRepositoryInterface,
                                DistrictRepositoryInterface $districtRepositoryInterface,
                                WardRepositoryInterface $wardRepositoryInterface,
                                CouponRepositoryInterface $couponRepositoryInterface,
                                OrderRepositoryInterface $orderRepositoryInterface,
                                OrderDetailRepositoryInterface $orderDetailRepositoryInterface) {
        $this->provinceRepo = $provinceRepositoryInterface;
        $this->districtRepo = $districtRepositoryInterface;
        $this->wardRepo = $wardRepositoryInterface;
        $this->couponRepo = $couponRepositoryInterface;
        $this->orderRepo = $orderRepositoryInterface;
        $this->orderDetailRepo = $orderDetailRepositoryInterface;
    }
    
    public function information() {
        $cart = session()->get('cart', []);
        $cartPro = session()->get('cartPro', []);
        $client = session()->get('client', []);
        if(empty($cart) || empty($cartPro)) {
            abort(404);
        }
        $wards = [];
        $districts = [];
        if($client) {
            $districts = $this->districtRepo->getDistrictByProvince($client['province']);
            $wards = $this->wardRepo->getWardsByDistrict($client['district']);
        }
        $pageTitle = 'Thanh toán';
        $provinces = $this->provinceRepo->getAll();
        
        return view('fontend.checkout.information', 
        compact('pageTitle', 'cart', 'cartPro', 'provinces', 'client', 'districts', 'wards'));
    }
    public function informationSave(Request $request) {
            $validationInput = $request->validate([
                'billing_address_full_name' => 'required|string|min:5|max:255',
                'billing_address_phone' => 'required|string|min:10|max:12',
                'billing_address_address' => 'required|string|min:10|max:255',
                'billing_shipping_province' => 'required',
                'billing_shipping_district' => 'required',
                'billing_shipping_ward' => 'required',
                'billing_email' => 'required|email|max:255',
            ], [
                'billing_address_full_name.required' => 'Vui lòng nhập họ và tên.',
                'billing_address_full_name.min' => 'Họ và tên phải có ít nhất 5 ký tự.',
                'billing_address_full_name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
                
                'billing_address_phone.required' => 'Vui lòng nhập số điện thoại.',
                'billing_address_phone.min' => 'Số điện thoại phải có ít nhất 10 ký tự.',
                'billing_address_phone.max' => 'Số điện thoại không được vượt quá 12 ký tự.',
                
                'billing_address_address.required' => 'Vui lòng nhập địa chỉ.',
                'billing_address_address.min' => 'Địa chỉ phải có ít nhất 10 ký tự.',
                'billing_address_address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
                
                'billing_shipping_province.required' => 'Vui lòng chọn tỉnh/thành phố.',
                'billing_shipping_district.required' => 'Vui lòng chọn quận/huyện.',
                'billing_shipping_ward.required' => 'Vui lòng chọn phường/xã.',
                
                'billing_email.required' => 'Vui lòng nhập email.',
                'billing_email.email' => 'Email không hợp lệ.',
                'billing_email.max' => 'Email không được vượt quá 255 ký tự.',
            ]);
        try {
            $client = session()->get('client', []);
            $client = [
                'full_name' => $request->billing_address_full_name,
                'phone' => $request->billing_address_phone,
                'address' => $request->billing_address_address,
                'province' => $request->billing_shipping_province ,
                'district' => $request->billing_shipping_district ,
                'ward' => $request->billing_shipping_ward,
                'email' => $request->billing_email,
                'note' => $request->billing_note
            ];
            session()->put('client', $client);
            
            return response()->json([
                'success' => true,
                'message' => 'Verify success',
                'data' => $client
            ]);

        } catch (\Exception $exception) {
            $status = $exception->getCode();
            return response()->json([
                'success' => false,
                'errors' => $exception->getMessage(),
                'message' => 'Verify failure',
            ], $status ?? 500);
        }

    }
    public function payment() {
        $cart = session()->get('cart', []);
        $cartPro = session()->get('cartPro', []);
        $client = session()->get('client', []);
        if(!$cart || !$cartPro || !$client) {
            abort(404);
        }
        $pageTitle = 'Thanh toán';
        
        return view('fontend.checkout.payment', compact('pageTitle', 'cart', 'cartPro', 'client'));
    }
    public function confirm() {

        try {
            $cart = session()->get('cart', []);
            $cartPro = session()->get('cartPro', []);
            $client = session()->get('client', []);
            if(empty($cart) || empty($cartPro) || empty($client)) {
                throw new Exception('Lỗi không xác định');
            }
            $province = $this->provinceRepo->getNameProvince($client['province']);
            $district = $this->districtRepo->getNameDistrict($client['district']);
            $ward = $this->wardRepo->getNameWard($client['ward']);
            if (!$province || !$district || !$ward) {
                throw new Exception('Address failure');
            }
            $data = [
                'name' => $client['full_name'],
                'phone' => $client['phone'],
                'province' => $province->full_name,
                'district' => $district->full_name,
                'ward' => $ward->full_name,
                'address' => $client['address'] ?? '',
                'email' => $client['email'],
                'note' => $client['note'],
                'total' => $cartPro['sumPrice'],
                'discount' => 0,
                'coupon_code' => '',
                'order_status_id' => 1,
                'payment_complete_date' => Carbon::now()
            ];
            if($cartPro['code']) {
                $data['discount'] = $cartPro['coupon_value'];
                $data['coupon_code'] = $cartPro['code'];
                $data['total'] = $cartPro['sumPrice'] - $cartPro['coupon_value'];
            }
            $order = $this->orderRepo->create($data);
            if(!$order) {
                throw new Exception('Create order failure', 400);
            }
            foreach ($cart as $item) {
                $this->orderDetailRepo->create([
                    'order_id' => $order->id,
                    'product_id' => $item['productId'],
                    'size_number' => $item['size_number'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity']
                ]);
            }
            session()->forget('cart');
            session()->forget('cartPro');
            session()->forget('client');
            return response()->json([
                'success' => true,
                'message' => 'Verify success',
                'data' => $cart
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Verify success',
                'errors' => $exception->getMessage()
            ], 500);
        }
    }

    public function getDistricts(Request $request) {
        $districts = $this->districtRepo->getDistrictByProvince($request->id);
        if($districts->isEmpty()) {
            return response()->json(['success' => false], 404);
        }
        return response()->json([
            'success' => true,
            'districts' => $districts,
        ], 200);
    }
    public function getWards(Request $request) {
        $wards = $this->wardRepo->getWardsByDistrict($request->id);
        if($wards->isEmpty()) {
            return response()->json(['success' => false], 404);
        }
        return response()->json([
            'success' => true,
            'wards' => $wards,
        ], 200);
    }
}
