<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookStore\StoreRequest;
use App\Http\Requests\BookStore\UpdateRequest;
use App\Models\BookStore;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookStoreController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        return $this->success(DB::table('book_stores')->paginate(10), 'List of books');
    }

    public function show(Request $request)
    {
        $bookStore = BookStore::find($request->book_store);
        if(!$bookStore){
            return $this->notFound(null, 'BookStore not found');
        }

        return $this->success($bookStore, 'Book found successfully');
    }

    public function store(StoreRequest $request)
    {
        $bookStore = BookStore::create($request->only(['name', 'isbn', 'value']));
        return $this->create($bookStore, 'Book created successfully');
    }

    public function destroy(Request $request)
    {
        $bookStore = BookStore::find($request->book_store);
        if(!$bookStore){
            return $this->notFound(null, 'BookStore not found');
        }
        $bookStore->delete();
        return response()->noContent();
    }

    public function update(UpdateRequest $request)
    {
        $bookStore = BookStore::find($request->book_store);
        if(!$bookStore){
            return $this->notFound(null, 'BookStore not found');
        }
        $name = $request->get('name');
        $isbn = $request->get('isbn');
        $value = $request->get('value');
        $data = [];
        if($name){
            $data['name'] = $name;
        }
        if($isbn){
            $data['isbn'] = $isbn;
        }
        if($value){
            $data['value'] = $value;
        }

        $bookStore = $bookStore->update($data);

        return $this->success($bookStore, 'Successfully updated');
    }
}
