<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Exports\ExportShop;
use App\Imports\ImportShop;
use Illuminate\Http\Request;
use Carbon\Exceptions\Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Shop";
        return view('shop.index', ['page_title' => $page_title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Shop";
        return view('shop.create', ['page_title' => $page_title]);
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
            'email' => 'bail|required|unique:shops',
            'name' => 'bail|required',
            'address' => 'bail|required',
            'file' => 'bail|required|mimes:jpeg,png,jpg,gif,svg|max:1999',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput()->with(['msg' => $error, 'class' => 'error']);
        }


        try {
            if ($request->hasFile('file')) {
                $filename = time() . time() . "." . $request->file('file')->getClientOriginalExtension();
                $path = "/shop";
                $image = $path . "/" . $filename;
                $request->file->move(public_path($path), $image);
            }


            $shop = new Shop();
            $shop->name = $request->name;
            $shop->email = $request->email;
            $shop->address = $request->address;
            $shop->image = $image;

            $shop->save();
            return redirect('admin/shop')->with(['msg' => "Shop Added", 'class' => 'success']);
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
        $shop = Shop::all();


        return DataTables::of($shop)
            ->addIndexColumn()
            ->addColumn('image', function ($shop) {
                if ($shop->image == "https://picsum.photos/200/300") {
                    return '<img src="' . $shop->image . '" width="100" style="    max-height: 80px;" />';
                }
                return '<img src="' . url('/') . $shop->image . '" width="100" style="    max-height: 80px;" />';
            })
            ->addColumn('action', function ($shop) {
                return '<a type="button" href="' . url("admin/shop/") . "/" . $shop->id . '/edit" class="btn-sm btn btn-outline-primary"><i class="fas fa-pencil-alt"></i></a>  <button type="button" data-id="delete" data-value="' . $shop->id . '" class="btn-sm btn btn-outline-danger "><i class="fas fa-trash "></i></button>';
            })
            ->rawColumns(['action', 'image'])

            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        $page_title = "Shop";

        return view('shop.edit', ['page_title' => $page_title, 'shop' => $shop]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'bail|required',
            'name' => 'bail|required',
            'address' => 'bail|required',
            'file' => 'bail|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect::back()->withInput()->with(['msg' => $error, 'class' => 'error']);
        }
        $email_exist = Shop::where([['email', '=', $request->email], ['id', '!=', $shop->id]])->exists();

        if ($email_exist) {
            return Redirect::back()
                ->withInput()
                ->with(['msg' => "Email Exist", 'class' => 'error']);
        }

        try {
            if ($request->hasFile('file')) {
                if ($shop->image != "https://picsum.photos/200/300") {
                    if (File::exists(public_path($shop->image))) {
                        File::delete(public_path($shop->image));
                    }
                }

                $filename = time() . time() . "." . $request->file('file')->getClientOriginalExtension();
                $path = "/shop";
                $image = $path . "/" . $filename;
                $request->file->move(public_path($path), $image);
            }



            $shop->name = $request->name;
            $shop->email = $request->email;
            $shop->address = $request->address;
            $shop->image = $request->hasFile('file') ?  $image : $shop->image;
            $shop->save();
            return redirect('admin/shop')->with(['msg' => "Shop Updated", 'class' => 'success']);
        } catch (Exception $e) {
            return Redirect::back()
                ->withInput()
                ->with(['msg' => 'Something Is Wrong', 'class' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {

        if ($shop->image != "https://picsum.photos/200/300") {
            if (File::exists(public_path($shop->image))) {
                File::delete(public_path($shop->image));
            }
        }
        $shop->delete();
        return response()->json(['message' => "Shop Deleted", 'status' => true], 200);
    }
    /**
     * export shops data csv file.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        return Excel::download(new ExportShop, 'shops.csv');
    }
    /**
     * import shops data csv file.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {

        Excel::import(new ImportShop, $request->file('file')->store('files'));
        return redirect('admin/shop')->with(['msg' => "Shop Imported", 'class' => 'success']);
    }
}
