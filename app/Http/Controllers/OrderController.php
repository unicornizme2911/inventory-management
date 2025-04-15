<?php

namespace App\Http\Controllers;

use App\Http\Services\OrderService;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ResponseAPI;
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        return view('order.list');
    }
    public function show(Request $request)
    {
        $order = $this->orderService->show($request->id);
        return view('order.detail', compact('order'));
    }
    public function checkout(){
        $user = auth()->user();
        return view('order.checkout', compact('user'));
    }
}
