<?php

namespace App\Http\Services;

use App\Http\Repositories\TransactionRepository;
use App\Http\Resources\TransactionResource;
use App\Models\TransactionModel;
use App\Traits\ResponseAPI;

class TransactionService extends BaseService
{
    use ResponseAPI;
    private $transactionRepository;
    public function __construct(TransactionRepository $transactionRepository)
    {
        parent::__construct(TransactionModel::class, TransactionResource::class);
        $this->transactionRepository = $transactionRepository;
    }

    public function store()
    {
        $transaction = $this->transactionRepository->store([
            'type' => 'pending'
        ]);
        if (!$transaction) {
            return $this->error('Transaction not created', 500);
        }
        return new TransactionResource($transaction);
    }

    public function addProductToTrans($data)
    {
        $transaction = $this->transactionRepository->storeDetail([
            'transaction_id' => $data['transaction_id'],
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'] ?? 1,
            'total_price' => $data['total_price']
        ]);
        if (!$transaction) {
            return $this->error('Transaction not created', 500);
        }
        return new TransactionResource($transaction);
    }

    public function show($id)
    {
        $transaction = $this->transactionRepository->show($id);
        if (!$transaction) {
            return $this->error('Transaction not found', 404);
        }
        return new TransactionResource($transaction);
    }
}
