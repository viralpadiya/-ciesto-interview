<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Carbon\Exceptions\Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Product";
        return view('product.index', ['page_title' => $page_title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shop = Shop::all();
        $page_title = "Product";
        return view('product.create', ['page_title' => $page_title, 'shop' => $shop]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required',
            'shop_id' => 'bail|required',
            'price' => 'bail|required',
            'stock' => 'bail|required',
            'file' => 'bail|required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:2048',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput()->with(['msg' => $error, 'class' => 'error']);
        }
        $product_exist = Product::where([['name', '=', $request->name], ['shop_id', '=', $request->shop_id]])->exists();
        if ($product_exist) {
            return Redirect::back()
                ->withInput()
                ->with(['msg' => "Product Exist In Same Shop", 'class' => 'error']);
        }


        try {
            if ($request->hasFile('file')) {
                $filename = time() . time() . "." . $request->file('file')->getClientOriginalExtension();
                $path = "/product/video";
                $video = $path . "/" . $filename;
                $request->file->move(public_path($path), $video);
            }


            $product = new Product();
            $product->name = $request->name;
            $product->shop_id = $request->shop_id;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->video = $video;

            $product->save();
            return redirect('admin/product')->with(['msg' => "Product Added", 'class' => 'success']);
        } catch (Exception $e) {
            return Redirect::back()
                ->withInput()
                ->with(['msg' => 'Something Is Wrong', 'class' => 'error']);
        }
    }

    /**
     * Store a newly data table resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function requestDatatable(Request $request)
    {
        $product = Product::select(['products.id', 'products.name', 'products.price', 'products.shop_id', 'products.video', 'products.stock', 'shops.name as shop_name'])
            ->leftJoin('shops', 'products.shop_id', '=', 'shops.id');

        if (isset($request->min) && !empty($request->min)) {
            $product = $product->where('products.price', '>=', $request->min);
        }
        if (isset($request->max) && !empty($request->max)) {
            $product = $product->where('products.price', '<=', $request->max);
        }


        return DataTables::of($product)
            ->addIndexColumn()
            ->addColumn('video', function ($product) {

                return '<video width="220" height="150" controls>
                            <source src="' . url('/') . $product->video . '">
                        </video>';
            })
            ->addColumn('action', function ($product) {
                return '<a type="button" href="' . url("admin/product/") . "/" . $product->id . '/edit" class="btn-sm btn btn-outline-primary"><i class="fas fa-pencil-alt"></i></a>  <button type="button" data-id="delete" data-value="' . $product->id . '" class="btn-sm btn btn-outline-danger "><i class="fas fa-trash "></i></button>';
            })
            ->rawColumns(['action', 'video'])

            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $shop = Shop::all();
        $page_title = "Product";
        return view('product.edit', ['page_title' => $page_title, 'shop' => $shop, 'product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required',
            'shop_id' => 'bail|required',
            'price' => 'bail|required',
            'stock' => 'bail|required',
            'file' => 'bail|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:2048',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput()->with(['msg' => $error, 'class' => 'error']);
        }
        $product_exist = Product::where([['name', '=', $request->name], ['shop_id', '=', $request->shop_id], ['id', '!=', $product->id]])->exists();
        if ($product_exist) {
            return Redirect::back()
                ->withInput()
                ->with(['msg' => "Product Exist In Same Shop", 'class' => 'error']);
        }


        try {
            if ($request->hasFile('file')) {

                if (File::exists(public_path($product->video))) {
                    File::delete(public_path($product->video));
                }

                $filename = time() . time() . "." . $request->file('file')->getClientOriginalExtension();
                $path = "/product/video";
                $video = $path . "/" . $filename;
                $request->file->move(public_path($path), $video);
            }



            $product->name = $request->name;
            $product->shop_id = $request->shop_id;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->video = $request->hasFile('file') ? $video : $product->video;
            $product->save();
            return redirect('admin/product')->with(['msg' => "Product Updated", 'class' => 'success']);
        } catch (Exception $e) {
            return Redirect::back()
                ->withInput()
                ->with(['msg' => 'Something Is Wrong', 'class' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (File::exists(public_path($product->video))) {
            File::delete(public_path($product->video));
        }
        $product->delete();
        return response()->json(['message' => "Product Deleted", 'status' => true], 200);
    }
}
