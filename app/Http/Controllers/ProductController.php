<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Validator;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function createData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'price' => 'required|numeric',
            'desc' => 'required|max:100'
        ]);

        if($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        Product::create([
            'name' => $request->product_name,
            'price' => $request->price,
            'desc' => $request->desc
        ]);
        return response()->json([
            'message' => 'success create data'
        ]);
    }

    public function getAllData()
    {
        $products = Product::All();
        return response()->json([
            'products' => $products
        ]);
    }

    public function getData($id)
    {
        $product = Product::findOrfail($id);
        return response()->json($product);
    }

    public function searchData(Request $request)
    {
        $products = Product::where('name', 'LIKE', '%'.$request->product_name.'%')->get();
                            // ->orwhere('price', 'LIKE', '%'.$request->price.'%')->get();
        return response()->json([
            'productSearch' => $products
        ]);
    }

    public function updateData(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'price' => 'required|numeric',
            'desc' => 'required|max:100'
        ]);

        if($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }

        Product::findOrfail($id)->update([
            'name' => $request->product_name,
            'price' => $request->price,
            'desc' => $request->desc
        ]);
        return response()->json([
            'message' => 'data successfully updated'
        ]);
    }

    public function deleteData($id)
    {
        Product::destroy($id);
        return response()->json([
            'message' => 'data deleted successfully'
        ]);
    }

}
