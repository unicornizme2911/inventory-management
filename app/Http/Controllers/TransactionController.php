<?php

namespace App\Http\Controllers;

use App\Http\Services\TransactionService;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use ResponseAPI;
    private $transactionService;
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function store(Request $request){
        $transaction = $this->transactionService->store();
        return $transaction ? $this->success('Transaction created successfully', $transaction) : $this->error('Transaction not created', 500);
    }

    public function addProductToTrans(Request $request)
    {
        $data = $request->validate([
            'transaction_id' => 'required|integer',
            'product_id' => 'required|integer',
            'total_price' => 'required|numeric'
        ]);

        $transaction = $this->transactionService->addProductToTrans($data);
        return $transaction ? $this->success('Product added to transaction successfully', $transaction) : $this->error('Transaction not updated', 500);
    }

    public function show(Request $request, $id)
    {
        $transaction = $this->transactionService->show($id);
        return $transaction ? $this->success('Transaction retrieved successfully', $transaction) : $this->error('Transaction not found', 404);
    }
}
