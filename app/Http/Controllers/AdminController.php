<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Notifications\SendEmailNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller
{
    public function view_category()
    {
        $categories = Category::get();
        return view('admin.category.view_category', compact('categories'));
    }
    public function add_category(Request $request)
    {
        $categoty = new Category();
        $categoty->category_name = $request->add_category;
        $categoty->save();
        return redirect()->back()->with('message', 'Category Added Successfully');
    }
    public function delete_category($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->back()->with('message', 'Category Deleted Successfully');
    }

    public function view_products()
    {
        $categories = Category::get();
        return view('admin.products.product', compact('categories'));
    }

    public function add_products(Request $request)
    {
        $product = new Product();
        $product->product_title = $request->product_title;
        $product->prouct_description = $request->prouct_description;
        $product->product_price = $request->product_price;
        $product->product_discount = $request->product_discount;
        $product->product_quentity = $request->product_quentity;
        $product->product_category = $request->product_category;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = rand(1, 1000) . '_' . $product->product_title . '-' . $request->file('image')->getClientOriginalName();
            $file->move('uploads', $filename);
            $product->product_image = $filename;
        }
        $product->save();
        return redirect()->back()->with('message', 'Product Added Successfully');
    }

    public function show_products()
    {
        $products = Product::get();
        return view('admin.products.show', compact('products'));
    }

    public function delete_products($id)
    {
        $products = Product::find($id);
        $products->delete();
        return redirect()->back()->with('message', 'Products Deleted Successfully');
    }
    public function edit_products($id)
    {
        $categories = Category::get();
        $products = Product::find($id);
        return view('admin.products.edit', compact('products', 'categories'));
    }
    public function update_products(Request $request, $id)
    {
        $product = Product::find($id);
        $product->product_title = $request->product_title;
        $product->prouct_description = $request->prouct_description;
        $product->product_price = $request->product_price;
        $product->product_discount = $request->product_discount;
        $product->product_quentity = $request->product_quentity;
        $product->product_category = $request->product_category;

        if ($request->hasFile('newimage')) {
            $destination = public_path('products' . $request->oldimage);
            if (file_exists($destination)) {
                unlink($destination);
            }
            $file = $request->file('newimage');
            $filename = rand(1, 1000) . '_' . $product->product_title . '-' . $request->file('newimage')->getClientOriginalName();
            $file->move('uploads', $filename);
            $product->product_image = $filename;
        }
        $product->save();
        session()->flash('success', 'Product updated successfully.');
        return redirect()->back();
    }

    public function order_details()
    {
        $orders = Order::get();
        return view('admin.orders.order', compact('orders'));
    }

    public function delevered($id)
    {
        $orders = Order::find($id);
        $orders->delivery_status = "Delivered";
        $orders->payment_status = "Paid";

        $orders->save();
        return redirect()->back();
    }

    public function print_pdf($id)
    {
        $orders = Order::find($id);

        $pdf = PDF::loadView('admin.orders.pdf', compact('orders'));
        return $pdf->download('order_details.pdf');
    }

    public function send_email($id)
    {
        $data = Order::find($id);
        return view('admin.orders.email_info', compact('data'));
    }
    public function send_user_email(Request $request, $id)
    {
        $order = Order::find($id);
      
        $details = [
            'greeting' => $request->greeting,
            'firstline' => $request->firstline,
            'body' => $request->body,
            'button' => $request->button,
            'url' => $request->url,
            'lastline' => $request->lastline
        ];
        Notification::send($order, new SendEmailNotification($details));
        return redirect()->back();
    }
    public function search(Request $request){
        $searchText=$request->search;
        $orders=Order::where("name","LIKE","%$searchText%")->get();
        return view('admin.orders.order',compact('orders'));
    }
}
