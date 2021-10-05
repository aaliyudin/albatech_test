<?php

namespace App\Http\Controllers;

//Configurations
use App\Http\Controllers\Midtrans\Config;

//API Resources
use App\Http\Controllers\Midtrans\Transaction;

//Plumbing
use App\Http\Controllers\Midtrans\ApiRequestor;
use App\Http\Controllers\Midtrans\SnapApiRequestor;
use App\Http\Controllers\Midtrans\Notification;
use App\Http\Controllers\Midtrans\CoreApi;
use App\Http\Controllers\Midtrans\Snap;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

//Sanitization
use App\Http\Controllers\Midtrans\Sanitizer;

class PaymentController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    //
  }

  public function getSnapUrl(Request $request)
  {
    $item_list = array();
    $amount = 0;
    Config::$serverKey = 'SB-Mid-server-gimmuYNM6DBt1VEKIMZc4-VV';
    if (!isset(Config::$serverKey)) {
      return "Please set your payment server key";
    }
    Config::$isSanitized = true;

    Config::$is3ds = true;

    $item_list = [];
    $gross_amount = 0;
    foreach ($request->items as $key => $item) {
      $item_list[] = $item;
      $gross_amount += $item['price'] * $item['quantity'];
    }

    $transaction_details = array(
    'order_id' => rand(),
    'gross_amount' => $gross_amount
    );

    $item_details = $item_list;

    $billing_address = $request->billing_address;

    $shipping_address = $request->billing_address;

    $customer_details = array(
    'first_name'    => $request->customer_details['first_name'],
    'last_name'     => $request->customer_details['last_name'],
    'email'         => $request->customer_details['email'],
    'phone'         => $request->customer_details['phone'],
    'billing_address'  => $billing_address,
    'shipping_address' => $shipping_address
    );


    $transaction = array(
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
    );

    try {
      $snapUrl = Snap::getSnapUrl($transaction);
      $data = [
        'snap_url' => $snapUrl
      ];

      return response()->json(
        [
          'status_code' => 200,
          'success' => true,
          'message' => 'Success',
          'data' => $data
        ], 200);
    } catch (\Exception $e) {
      return response()->json(
        [
          'status_code' => 500,
          'success' => true,
          'message' => $e->getMessage(),
          'data' => []
        ], 200);
    }

  }
}
