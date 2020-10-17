<?php

namespace App\Http\Controllers\API\v1\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Inventory\Stock;
use App\Model\Inventory\StockIn;
use App\Model\Inventory\StockOut;
use App\Model\Main\Book;
use App\Http\Resources\Inventory\StockResource;
use App\Http\Resources\Main\BookResource;
use Auth;

class StockController extends Controller
{
    public function index()
    {
        $stock = Stock::with(['book'])
                ->orderBy('id', 'DESC')
                ->get();

        if ($stock->count() == 0)
        {
            return $this->sendEmpty();
        }

        return $this->sendResponse(StockResource::collection($stock), 'Retrieve books stock successfully');
    }

    public function show($id)
    {
        $book = $this->findBookByBookId($id);

        if (!$book)
        {
            return $this->sendNoData();
        }

        return $this->sendResponse(new BookResource($book), 'Get data book successfully');
    }

    public function stockIn(Request $request)
    {
        $this->__validate($request);

        $stock = StockIn::create([
            'amount'        => $request->amount,
            'last_stock'    => $request->last_stock,
            'description'   => $request->description,
            'book_id'       => $request->book_id,
            'user_id'       => Auth::id()
        ]);

        return $this->storeIn($request);
    }

    public function stockOut(Request $request)
    {
        $this->__validate($request);

        $find = $this->findStockByBookId($request->book_id);

        if(!$find)
        {
            return $this->sendNoData();
        }

        if ($request->last_stock != $find->amount)
        {
            return $this->sendInvalidStock();
        }

        if($find->amount < $request->amount) {
            return $this->sendErrorAmount();
        }

        $stock = StockOut::create([
            'amount'        => $request->amount,
            'last_stock'    => $request->last_stock,
            'description'   => $request->description,
            'book_id'       => $request->book_id,
            'user_id'       => Auth::id()
        ]);

        return $this->storeOut($request);
    }

    public function storeIn($request)
    {
        $find = $this->findStockByBookId($request->book_id);

        if ($find)
        {
            return $this->updateIn($request);
        }

        $stock = Stock::create([
            'amount'    => $request->amount,
            'book_id'   => $request->book_id
        ]);

        return $this->sendResponse(new StockResource($stock), 'Insert stock in successfully');
    }

    public function storeOut($request)
    {
        $stock = $this->findStockByBookId($request->book_id);

        $stock->update([
            'amount' => $stock->amount - $request->amount
        ]);

        return $this->sendResponse(new StockResource($stock), 'Insert stock out successfully');
    }

    public function updateIn($request)
    {
        $stock = $this->findStockByBookId($request->book_id);

        $amount = $stock->amount;

        $stock->update([
            'amount' => $amount + $request->amount
        ]);

        return $this->sendResponse(new StockResource($stock), 'Update book stock successfully');
    }

    public function __validate($request)
    {
        return $this->validate($request, [
            'amount'        => 'required|integer',
            'last_stock'    => 'required|integer',
            'book_id'       => 'required|integer|exists:tm_book,id'
        ]);
    }

    public function findStockByBookId($id)
    {
        $stock = Stock::where('book_id', $id)
                ->first();

        return $stock;
    }

    public function findBookByBookId($id)
    {
        $book = Book::where('id', $id)
                ->with(['stock'])
                ->first();

        return $book;
    }
}
