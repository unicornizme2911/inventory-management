<?php

namespace App\Http\Repositories;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class TransactionRepository
{
    public function store($data)
    {
        $transaction = new TransactionModel();
        $transaction->type = $data['type'];
        $transaction->save();
        return $transaction;
    }
    public function storeDetail($data)
    {
        $transaction = TransactionDetailModel::where('transaction_id', $data['transaction_id'])
                                             ->where('product_id', $data['product_id'])->first();
        if($transaction){
            $transaction->quantity += $data['quantity'];
            $transaction->total_price += $data['total_price'];
            $transaction->save();
            return $transaction;
        }
        $transactionDetail = new TransactionDetailModel();
        $transactionDetail->transaction_id = $data['transaction_id'];
        $transactionDetail->product_id = $data['product_id'];
        $transactionDetail->quantity = $data['quantity'];
        $transactionDetail->total_price = $data['total_price'];
        $transactionDetail->save();
        return $transactionDetail;
    }

    public function show($id)
    {
        $transaction = TransactionModel::with('products')->find($id);
        if (!$transaction) {
            return null;
        }
        return $transaction;
    }
}
