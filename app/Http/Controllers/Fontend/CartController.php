<?php
namespace App\Http\Controllers\Fontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepositoryInterface;
use PhpParser\Node\Stmt\TryCatch;

class CartController extends Controller
{
    protected $productRepo;
    public function __construct(ProductRepositoryInterface $productRepositoryInterface) {
        $this->productRepo = $productRepositoryInterface;
    }
    public function index() {
        $pageTitle = 'Giỏ hàng';
        return view('fontend.cart.index', compact('pageTitle'));

    } 
    public function store(Request $request) {
        try {
            $product = $this->productRepo->find($request->id);
            
            if(!$product) {
                throw new \Exception("Không tìm thấy sản phẩm", 404);
            }
            if(!$request->cartId) {
                throw new \Exception("Không tìm thấy ID giỏ hàng", 400);
            }        
            $cartId = str_replace('.', '', $request->cartId);    
            $cart = session()->get('cart', []);
            $currPrice = ($product->sale_price > 0) ? $product->sale_price : $product->price;
            if(!isset($cart[$cartId])) {
                $cart[$cartId] = [
                    'cartId' => $cartId,
                    'productId' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'image' => $product->image,
                    'priceDefalt' =>  $currPrice,
                    'price' => $currPrice * $request->quantity,
                    'code' => $product->code,
                    'quantity' => $request->quantity,
                    'size_number' => $request->size_number,
                    'maxQuantity' => $request->maxQuantity,
                ];
            }else{
                $cart[$cartId]['quantity'] += $request->quantity;
                $cart[$cartId]['price'] = $currPrice * $cart[$cartId]['quantity'];
            }
            session()->put('cart', $cart);
            $cartPro = $this->updateCartPro($cart);
            return response()->json([
                'success' => true,
                'message' => 'Create success',
                'cart' => [
                    'data' => $cart,
                    'totalQuantity' => $cartPro['totalQuantity'],
                    'sumPrice' =>  $cartPro['sumPrice'],
                    'currentName' => $cart[$cartId]['name']
                ],
            ], 200);
        } catch (\Exception $exception) {
            $status = $exception->getCode();
            return response()->json([
                'success' => false,
                'message' => 'Create failed',
                'errors' => $exception->getMessage()
            ], $status ?? 500);
        }
    }
    public function updateQuantity(Request $request) {

        try {
            
            $cartId = $request->cartId;
            if(!$cartId) {
                throw new \Exception("ID rỗng", 404);
            }
            $cart = session()->get('cart', []);
            if(!isset($cart[$cartId])) {
                throw new \Exception("Không tồn tại sản phẩm trong giỏ", 404);
            }
            $cart[$cartId]['price'] = $cart[$cartId]['priceDefalt'] * $request->quantity;
            $cart[$cartId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            $cartPro = $this->updateCartPro($cart);
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Update success', 
                    'cart' => [
                        'price' => $cart[$cartId]['price'],
                        'totalQuantity' => $cartPro['totalQuantity'],
                        'sumPrice' =>  $cartPro['sumPrice'],
                    ], 
                ], 200);
        } catch (\Exception $exception) {
            $status = $exception->getCode();
            return response()->json([
                'success' => false,
                'message' => 'Create failed',
                'errors' => $exception->getMessage()
            ], $status ?? 500);
        }
       
    }
    private function updateCartPro($cartSession) {
        $cartPro = session()->get('cartPro', []);
        $cartPro['sumPrice'] = 0;
        $cartPro['totalQuantity'] = 0;
        $cartPro['coupon_value'] = 0;
        $cartPro['code'] = '';
        foreach($cartSession as $session) {
            $cartPro['sumPrice'] += $session['price'];
            $cartPro['totalQuantity'] += $session['quantity'];
        }
        session()->put('cartPro', $cartPro);
        return $cartPro;
    }
    public function delete(Request $request) {
        $cart = session()->get('cart', []);
        $cartId = $request->cartId;
        if(isset($cart[$cartId])) {
            unset($cart[$cartId]);
            session()->put('cart', $cart);
            $cartPro = $this->updateCartPro($cart);
            return response()
            ->json([
                'msg' => 'Cập nhật thành công', 
                'cartPro' => session()->get('cartPro', [])
            ], 200);
        }
        return response()->json(['msg' => 'Sản phẩm không tồn tại trong giỏ hàng!'], 404);
    }
}
