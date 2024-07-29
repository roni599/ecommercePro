<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Stripe;
use RealRashid\SweetAlert\Facades\Alert;


class HomeController extends Controller
{
    public function index()
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $carts = cart::where('user_id', '=', $id)->get();
            $products = Product::paginate(6);
            return view('home.userpage', compact('carts', 'products'));
        } else {
            $products = Product::paginate(6);
            return view('home.userpage', compact('products'));
        }
    }
    public function cart_details()
    {
        $carts = cart::where('user_id', '=', 5)->get();
        return response()->json($carts);
    }
    public function redirect()
    {
        $usertype = Auth::user()->usertype;

        if ($usertype === '1') {
            $products = Product::all()->count();
            $orders = Order::all()->count();
            $customers = User::all()->count();
            $revenue = Order::all();
            $total = 0;
            foreach ($revenue as $revenue) {
                $total = $total + $revenue->price;
            }
            $delivery_status = Order::where('delivery_status', '=', 'Delivered')->get()->count();
            $order_status = Order::where('delivery_status', '=', 'Delivered')->get()->count();
            return view('admin.home', compact('customers', 'products', 'orders', 'total', 'delivery_status', 'order_status'));
        } else {
            $products = Product::paginate(6);
            $id = Auth::user()->id;
            $carts = cart::where('user_id', '=', $id)->get();
            // $carts = Cart::all();

            return view('home.userpage', compact('products', 'carts'));
        }
    }

    public function product_details($id)
    {
        $product = Product::find($id);
        $carts = cart::where('user_id', '=', $id)->get();
        $comment = Comment::where('product_id', '=', $id)->orderby('id', 'desc')->get();
        $reply = Reply::all();
        return view('home.product_details', compact('product', 'comment', 'reply', 'carts'));
    }

    public function contact()
    {
        $carts = collect();
        return view('home.contact', compact('carts'));
    }

    public function add_cart(Request $request, $id)
    {
        if (Auth::id()) {
            $user = Auth::user();
            $user_id = $user->id;
            $product = Product::find($id);

            $product_exit_id = Cart::where('product_id', '=', $id)->where('user_id', '=', $user_id)->get('id')->first();
            if ($product_exit_id) {
                $cart = Cart::find($product_exit_id)->first();
                $cartQuentity = $cart->quentity;
                $cart->quentity = $cartQuentity + $request->quentity;
                if ($product->product_discount != null) {
                    $cart->price = $product->product_discount * $cart->quentity;
                } else {
                    $cart->price = $product->product_price * $cart->quentity;
                }
                $cart->save();
                Alert::success('Product Added successfully', 'We have added product to the cart');
                return redirect()->back();
            } else {
                $cart = new Cart();

                $cart->name = $user->name;
                $cart->email = $user->email;
                $cart->phone = $user->phone;
                $cart->address = $user->address;

                $cart->product_title = $product->product_title;
                if ($product->product_discount != null) {
                    $cart->price = $product->product_discount * $request->quentity;
                } else {
                    $cart->price = $product->product_price * $request->quentity;
                }
                $cart->quentity = $request->quentity;
                $cart->image = $product->product_image;
                $cart->product_id = $product->id;
                $cart->user_id = $user->id;
                $cart->save();
                Alert::success('Product Added successfully', 'We have added product to the cart');
                return redirect()->back();
            }
        } else {
            return redirect('login');
        }
    }

    public function cart_show()
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $carts = cart::where('user_id', '=', $id)->get();
            return view('home.cartshow', compact('carts'));
        } else {
            return redirect('login');
        }
    }

    public function remove_cart($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        Alert::success('Product Removed', 'We have remove a product from the cart');
        return redirect()->back();
    }

    public function cash_order()
    {
        $user = Auth::user();
        $userid = $user->id;
        $datas = Cart::where('user_id', '=', $userid)->get();
        foreach ($datas as $data) {
            $order = new Order();

            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;

            $order->product_title = $data->product_title;
            $order->quentity = $data->quentity;
            $order->price = $data->price;
            $order->image = $data->image;
            $order->product_id = $data->product_id;
            $order->payment_status = "cash on delivery";
            $order->delivery_status = "processing";

            $order->save();

            $cart_id = $data->id;
            $cart = Cart::find($cart_id);
            $cart->delete();
        }
        return redirect()->back()->with('message', 'We have Received your order, We will connect with you soon');
    }

    public function stripe($total)
    {
        $carts = Cart::all();
        return view('home.stripe', compact('total', 'carts'));
    }

    public function stripePost(Request $request, $total)
    {

        Stripe\Stripe::setApiKey('sk_test_51NyEcgKs3NOZcWUGPQjQZkvU09S27KaNAs4tpGDb8Ht43KB5lmb1qhJd6F4XsEL1PwaRFqpJ8XYgvtK7XE7scrnI00ifSCyE6M');
        Stripe\Charge::create([
            "amount" => $total * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Thanks for payment"
        ]);
        $user = Auth::user();
        $userid = $user->id;
        $datas = Cart::where('user_id', '=', $userid)->get();
        foreach ($datas as $data) {
            $order = new Order();

            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;

            $order->product_title = $data->product_title;
            $order->quentity = $data->quentity;
            $order->price = $data->price;
            $order->image = $data->image;
            $order->product_id = $data->product_id;
            $order->payment_status = "Paid";
            $order->delivery_status = "processing";

            $order->save();

            $cart_id = $data->id;
            $cart = Cart::find($cart_id);
            $cart->delete();
        }
        Session::flash('success', 'Payment successful!');
        return back();
    }

    public function order_view()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $orders = Order::where('user_id', '=', $userid)->get();
            $carts = Cart::all();
            return view('home.oreder', compact('orders', 'carts'));
        } else {
            return redirect('login');
        }
    }
    public function cancel_order($id)
    {
        $order = Order::find($id);
        $order->delivery_status = "Canceled the order";
        $order->save();
        return redirect()->back();
    }

    public function add_comment(Request $request)
    {
        if (Auth::id()) {
            $comment = new Comment();
            $comment->name = Auth::user()->name;
            $comment->comment = $request->comment;
            $comment->product_id = $request->product_id;
            $comment->user_id = Auth::user()->id;
            $comment->save();
            return redirect()->back();
        } else {
            return redirect('login');
        }
    }
    public function add_reply(Request $request)
    {
        if (Auth::id()) {
            $reply = new Reply();
            $reply->name = Auth::user()->name;
            $reply->user_id = Auth::user()->id;
            $reply->comment_id = $request->commentId;
            $reply->reply = $request->reply;
            $reply->save();
            return redirect()->back();
        } else {
            return redirect('login');
        }
    }
    public function search_product(Request $request)
    {
        $serarch_text = $request->search;
        $id = Auth::user()->id;
        $carts = cart::where('user_id', '=', $id)->get();
        $products = Product::where('product_title', 'LIKE', "%$serarch_text%")->paginate(10);

        return view('home.userpage', compact('products', 'carts'));
    }

    // public function all_products()
    // {
    //     $products = Product::paginate(6);
    //     // $carts = Cart::all();


    //     if ($id = Auth::user()->id) {
    //         $carts = cart::where('user_id', '=', $id)->get();
    //         return view('home.all_priduct', compact('products', 'carts'));
    //     } else {
    //         return redirect()->back();
    //     }
    // }


    public function all_products()
    {
        $products = Product::paginate(6);

        if (Auth::check()) {
            $id = Auth::user()->id;
            $carts = Cart::where('user_id', '=', $id)->get();
            return view('home.all_priduct', compact('products', 'carts'));
        } else {
            $carts = collect();
            return view('home.all_priduct', compact('products', 'carts'));
        }
    }


    public function product_search(Request $request)
    {
        $serarch_text = $request->search;
        $id = Auth::user()->id;
        $carts = cart::where('user_id', '=', $id)->get();
        $products = Product::where('product_title', 'LIKE', "%$serarch_text%")->paginate(10);
        return view('home.all_priduct', compact('products', 'carts'));
    }
}
