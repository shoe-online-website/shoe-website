<?php
namespace App\Http\Controllers\Fontend;

use App\Http\Controllers\Controller;
use App\Repositories\Coupon\CouponRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
class CouponController extends Controller
{
    protected $couponRepo;
    public function __construct(CouponRepositoryInterface $couponRepositoryInterface) {
        $this->couponRepo = $couponRepositoryInterface;
    }
    
    public function verify(Request $request) {
        try {
            $code = $request->code;
            if(!$code) {
                throw new Exception('Vui lòng nhập mã giảm giá', 400);
            }
            $coupon = $this->couponRepo->getCouponByCode($code);
            if(!$coupon) {
                throw new Exception('Mã giảm giá không tồn tại', 400);
            }
            $cartPro = session()->get('cartPro', []);
            if(!isset($cartPro)) {
                throw new Exception('Lỗi không xác định', 400);
            }
            $today = Carbon::now()->format('Y-m-d H:i:s');
            $startDate = $coupon->start_date;
            $endDate = $coupon->end_date;
            if((!$startDate && !$endDate) || ($today > $startDate && $today < $endDate)) {
                if($coupon->discount_type == 'percent') {
                    $cartPro['coupon_value'] = ($cartPro['sumPrice'] * $coupon->discount_value) / 100;
                    
                }
                if($coupon->discount_type == 'value') {
                    $cartPro['coupon_value'] = $coupon->discount_value;
                }
                $cartPro['code'] = $code;
                session()->put('cartPro', $cartPro);
                return response()->json([
                    'message' => 'Verify success',
                    'success' => true,
                    'cart' => [
                        'discount' => $cartPro['coupon_value'],
                        'code' => $cartPro['code'],
                        'sumPrice' => $cartPro['sumPrice'] - $cartPro['coupon_value']
                    ]
                ], 200);
            }
            throw new Exception('Mã giảm giá đã hết hạn sử dụng', 400);
        } catch (\Exception $exception) {
            $status = $exception->getCode();
            return response()->json([
                'message' => 'Verify failure',
                'success' => false,
                'errors' => $exception->getMessage()
            ], $status ?? 500);
        }
    }
    public function remove(Request $request) {
        try {
            $code = $request->code;
            if(!$code) {
                throw new Exception('Vui lòng nhập mã giảm giá', 400);
            }
            $coupon = $this->couponRepo->getCouponByCode($code);
            if(!$coupon) {
                throw new Exception('Mã giảm giá không tồn tại', 400);
            }
            $cartPro = session()->get('cartPro', []);
            if(!isset($cartPro)) {
                throw new Exception('Lỗi không xác định', 400);
            }
            $cartPro['coupon_value'] = 0;
            $cartPro['code'] = '';
            session()->put('cartPro', $cartPro);
            return response()->json([
                'message' => 'update success',
                'success' => true,
                'sumPrice' => $cartPro['sumPrice']
            ], 200);
        } catch (\Exception $exception) {
            $status = $exception->getCode();
            return response()->json([
                'message' => 'Verify failure',
                'success' => false,
                'errors' => $exception->getMessage()
            ], $status ?? 500);
        }
    }
}
