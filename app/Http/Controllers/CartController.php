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
        $data['currencySymbol'] = restaurant_detail()['restaurantDetail']['currency_symbol'];

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
                $item['rowTotal'] = number_format($item['comboTotal'] * $item['quantity'], 2);
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
                'productPrice'  => number_format($productDetail['price'], 2),
                'options'       => $options,
                'optionNames'   => $optionNames,
                'quantity'      => 1,
                'rowTotal'      => number_format($productDetail['price'] + $optionsPrice, 2),
                'comboTotal'    => number_format($productDetail['price'] + $optionsPrice, 2),
                'productInstruction' => $productInstruction
            ];
        }

        // Calculate the subtotal
        $subTotal = 0;
        foreach ($cart as $product) {
            $subTotal += $product['rowTotal'];
        }
        $formattedSubTotal = number_format($subTotal, 2);

        Session::put('cart', $cart);
        Session::put('cartSubTotal', $formattedSubTotal);

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
        if(Session::get('cart')){
            // Get Stripe Key
            $serverUrl  = env('SERVER_URL');
            $apiToken   = env('API_TOKEN');
            $url        = 'api/stripe/config';
        
            // Make the API request
            $response = Http::withHeaders([
                'Authorization' => $apiToken,
            ])->get($serverUrl . $url);

            $data['cartItems']      = Session::get('cart');
            $data['cartSubTotal']   = Session::get('cartSubTotal');
            $data['orderType']      = Session::get('orderType');
            $data['stripeKey']      = $response['data']['stripeKey'];

            $restaurantDetail = $this->restaurant_detail();
            $data['deliveryRadius'] = $restaurantDetail['restaurantDetail']['radius'];
            $data['restaurantLat'] = $restaurantDetail['restaurantDetail']['latitude'];
            $data['restaurantLng'] = $restaurantDetail['restaurantDetail']['longitude'];
            $data['freeShippingAmount'] = $restaurantDetail['restaurantDetail']['amount'];
            $data['currencySymbol'] = $restaurantDetail['restaurantDetail']['currency_symbol'];
            $data['pickupMiniAmount'] = $restaurantDetail['restaurantDetail']['pickup_minimum_amount'];
            $data['deliveryMiniAmount'] = $restaurantDetail['restaurantDetail']['delivery_minimum_amount'];
            $data['deliveryCharges'] = $restaurantDetail['restaurantDetail']['delivery_charges'];
            
            return view('pages.checkout', $data);
        }
        else{
            return redirect()->route('cart.view');
        }
    }

    public function checkout_process(Request $request)
    {
        $request->validate([
            'name'              => 'required',
            'phone'             => 'required',
            'email'             => 'required',
            'order_type'        => 'required|in:pickup,delivery',
            'payment_option'    => 'required|in:cash,online',
            'payment_method_id' => 'required_if:payment_option,online', // Only required for card payments
        ]);

        $orderTotal = Session::get('cartSubTotal');
        $restaurantDetail = $this->restaurant_detail();
        $pickupMiniAmount = $restaurantDetail['restaurantDetail']['pickup_minimum_amount'];
        $deliveryMiniAmount = $restaurantDetail['restaurantDetail']['delivery_minimum_amount'];

        if(($request->order_type == 'pickup' && $orderTotal < $pickupMiniAmount) || ($request->order_type == 'delivery' && $orderTotal < $deliveryMiniAmount)){
            return redirect()->route('checkout')->with('error', 'Order amount must be at least '. $pickupMiniAmount . ' for pickup OR ' . $deliveryMiniAmount . ' for delivery.');
        }

        $deliveryCharges = 0;
        if($request->order_type == 'delivery'){
            $custLat = $request->latitude;
            $custLng = $request->longitude;
            if(Session::get('cartSubTotal') < $restaurantDetail['restaurantDetail']['amount']){
                $deliveryCharges = $this->calculateDeliveryCharges($restaurantDetail['restaurantDetail'], $custLat, $custLng);
            }

            $coordinates = [
                'lat' => $request->latitude,
                'lng' => $request->longitude,
            ];
        }

        $postData['name']           = $request->name;
        $postData['email']          = $request->email ?? NULL;
        $postData['phone']          = $request->phone;
        $postData['address']        = $request->address ?? NULL;
        $postData['city']           = $request->city ?? NULL;
        $postData['postcode']       = $request->postcode ?? NULL;
        $postData['coordinates']    = $request->address ? $coordinates : NULL;
        $postData['paymentOption']  = $request->payment_option;
        $postData['orderNote']      = $request->note;
        $postData['payment_method_id'] = $request->payment_method_id;
        $postData['cartItems']      = Session::get('cart');
        $postData['cartSubTotal']   = Session::get('cartSubTotal');
        $postData['cartTotal']      = Session::get('cartSubTotal');
        $postData['orderType']      = $request->order_type;
        $postData['discountCode']   = $request->applied_code ?? null;
        $postData['deliveryCharges'] = $deliveryCharges;

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

        $data['orderData'] = $response->json('orderDetails');
        $restaurantDetail = $this->restaurant_detail();
        $data['freeShippingAmount'] = $restaurantDetail['restaurantDetail']['amount'];
        $data['currencySymbol'] = $restaurantDetail['restaurantDetail']['currency_symbol'];

        // Redirect to the order page
        return view('pages.order', $data);
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

    public function calculateDeliveryCharges($restaurantDetail, $custLat, $custLng)
    {
        $restaurantLat = $restaurantDetail['latitude'];
        $restaurantLng = $restaurantDetail['longitude'];
        
        $deliveryCharges = $restaurantDetail['delivery_charges'];

        $earthRadius = 6371000;
        $dLat = deg2rad($custLat - $restaurantLat);
        $dLng = deg2rad($custLng - $restaurantLng);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($restaurantLat)) * cos(deg2rad($custLat)) * sin($dLng / 2) * sin($dLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distanceMeters = $earthRadius * $c;

        $distanceKm = $distanceMeters / 1000; 

        $deliveryCharge = 0;
        foreach ($deliveryCharges as $charge) {
            if ($distanceKm >= $charge['min_distance'] && $distanceKm < $charge['max_distance']) {
                $deliveryCharge = (float) $charge['charge'];
                break;
            }
        }

        return $deliveryCharge;
    }
}
