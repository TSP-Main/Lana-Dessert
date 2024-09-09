<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{
    protected $apiController;

    public function __construct(ApiController $apiController)
    {
        $this->apiController = $apiController;
    }

    public function view(Request $request)
    {
        $data['cartItems'] = Session::get('cart');
        $data['cartSubTotal'] = Session::get('cartSubTotal');
        return view('pages.cart', $data);
    }

    public function add(Request $request)
    {
        $productId      = $request->data['product_id'];
        $options        = $request->data['options'] ?? NULL;
        $optionNames    = $request->data['optionNames'] ?? NULL;
        $productInstruction = $request->data['product_instruction'];

        // fetch product detail using api
        $response_product = $this->apiController->product($productId);
        $productDetail =  collect($response_product['products'])->first();

        // fetch product sides/options detail for total price
        $optionsPrice = 0;
        if($options){
            $responseOptions = collect($this->apiController->options_detail(array_values($options))['options']);
            $optionsPrice = $responseOptions->sum('price');
        }

        $cart = Session::get('cart', []);

        // Check if product already exists in the cart
        $productExists = false;
        foreach ($cart as &$item) {
            if ($item['productId'] == $productId && $item['options'] == $options) {
                $item['quantity']++;
                $item['rowTotal'] = $item['comboTotal'] * $item['quantity'];
                $productExists = true;
                break;
            }
        }

        $rowId = $productId.time();
        if (!$productExists) {
            $cart[$rowId] = [
                'rowId'         => $rowId,
                'productId'     => $productId,
                'productTitle'  => $productDetail['title'],
                'productImage'  => $productDetail['images'],
                'productPrice'  => $productDetail['price'],
                'options'       => $options,
                'optionNames'   => $optionNames,
                'quantity'      => 1,
                'rowTotal'      => $productDetail['price'] + $optionsPrice,
                'comboTotal'    => $productDetail['price'] + $optionsPrice,
                'productInstruction' => $productInstruction
            ];
        }

        // Calculate the subtotal
        $subTotal = 0;
        foreach ($cart as $product) {
            $subTotal += $product['rowTotal'];
        }

        Session::put('cart', $cart);
        Session::put('cartSubTotal', $subTotal);

        return response()->json(['success' => true, 'message' => 'Product added to cart']);
    }

    public function update(Request $request)
    {
        $rowId = $request->row_id;
        $quantity = $request->quantity;

        $cart = Session::get('cart', []);

        $rowTotal = 0;
        foreach ($cart as &$item) {
            if ($item['rowId'] == $rowId) {
                $item['quantity'] = $quantity;
                $item['rowTotal'] = $quantity * $item['comboTotal'];
                $rowTotal = $item['rowTotal'];
                break;
            }
        }

        // Calculate the subtotal
        $subTotal = 0;
        foreach ($cart as $product) {
            $subTotal += $product['rowTotal'];
        }

        Session::put('cart', $cart);
        Session::put('cartSubTotal', $subTotal);
        
        return response()->json(['success' => true, 'message' => 'Cart updated successfully', 'rowTotal' => $rowTotal, 'cartSubTotal' => $subTotal]);
    }

    public function delete(Request $request)
    {
        $cart = Session::get('cart', []);
        $rowId = $request->row_id;

        if (isset($cart[$rowId])) {
            unset($cart[$rowId]);

            // Calculate the subtotal
            $subTotal = 0;
            foreach ($cart as $product) {
                $subTotal += $product['rowTotal'];
            }

            Session::put('cart', $cart);
            Session::put('cartSubTotal', $subTotal);

            return response()->json(['message' => 'Success', ], 200);
        }

        return response()->json(['message' => 'error'], 404);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'order_type' => 'required|in:pickup,delivery'
        ]);

        Session::put('orderType', $request->order_type);

        $data['cartItems']      = Session::get('cart');
        $data['cartSubTotal']   = Session::get('cartSubTotal');
        $data['orderType']      = Session::get('orderType');
        $data['stripeKey']      = env('STRIPE_API_KEY');

        // dd($data);

        $restaurantDetail = $this->restaurant_detail();
        $data['deliveryRadius'] = $restaurantDetail['restaurantDetail']['radius'];
        $data['restaurantLat'] = $restaurantDetail['restaurantDetail']['latitude'];
        $data['restaurantLng'] = $restaurantDetail['restaurantDetail']['longitude'];
        
        return view('pages.checkout', $data);
    }

    public function checkout_process(Request $request)
    {
        $request->validate([
            'name'              => 'required',
            'phone'             => 'required',
            'payment_option'    => 'required|in:cash,online',
            'payment_method_id' => 'required_if:payment_option,online', // Only required for card payments
        ]);


        $postData['name']           = $request->name;
        $postData['email']          = $request->email ?? NULL;
        $postData['phone']          = $request->phone;
        $postData['address']        = $request->address ?? NULL;
        $postData['coordinates']    = $request->address ?? NULL;
        $postData['paymentOption']  = $request->payment_option;
        $postData['orderNote']      = $request->note;
        $postData['payment_method_id'] = $request->payment_method_id;
        $postData['cartItems']      = Session::get('cart');
        $postData['cartSubTotal']   = Session::get('cartSubTotal');
        $postData['cartTotal']      = Session::get('cartSubTotal');
        $postData['orderType']      = Session::get('orderType');

        $serverUrl  = env('SERVER_URL');
        $apiToken   = env('API_TOKEN');
        $url        = 'api/order/store';
    
        // Make the API request
        $response = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->post($serverUrl . $url, $postData);

        // Handle the response
        if ($response->json('status') === 'success') {
            // Clear session data if payment is successful
            Session::flush();
        }

        // Flash the response message to the session
        Session::flash('response', $response->json('message'));
    
        // Redirect to the order page
        return redirect()->route('order');
    }
    
    public function getCartCount()
    {
        $cart = Session::get('cart', []);
        $totalItems = array_sum(array_column($cart, 'quantity')); // Sum up quantities of all items
        return response()->json(['count' => $totalItems]);
    }


    public function order()
    {
        return view('pages.order');
    }

    public function destroy()
    {
        Session::flush();
    }

    public function restaurant_detail()
    {
        $serverUrl = env('SERVER_URL');
        $apiToken = env('API_TOKEN');
        
        $response = Http::withHeaders([
            'Authorization' => $apiToken,
        ])->get($serverUrl . 'api/restaurant_detail');

        if($response['status'] == 'success'){
            $data['response'] = true;
            $data['restaurantDetail'] = $response['data'];
        }
        else{
            $data['response'] = false;
        }
        
        return $data;
    }
}
