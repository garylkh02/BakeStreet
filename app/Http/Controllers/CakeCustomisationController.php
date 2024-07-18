<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CakeCusReceipt;
use App\Models\Topping;
use App\Models\Flavour;
use App\Models\Bakery;
use App\Models\Category;
use App\Models\CakeCustomisation;

class CakeCustomisationController extends Controller
{
    public function showCustomisationForm()
    {
        $flavours = Flavour::all();
        $toppings = Topping::all();
        $bakeries = Bakery::all();
        $categories = Category::all();

        return view('cakecustomisation', compact('flavours', 'toppings', 'bakeries', 'categories'));
    }

    public function submitCustomisationForm(Request $request)
    {
        $cake_customisations = new CakeCustomisation();
    
        $cake_customisations->bakery_id = $request->input('bakery_id');
        $cake_customisations->quantity = $request->input('quantity');
        $cake_customisations->category_id = $request->input('category');
        $cake_customisations->toppings_id = $request->input('toppings');
        $cake_customisations->flavours_id = $request->input('flavours');
        $cake_customisations->message_on_cake = $request->input('message_on_cake');
        $cake_customisations->message=$request->cardmsg;
        $cake_customisations->deldate=$request->selected_date;
        $cake_customisations->deltime=$request->selected_time;
        $cake_customisations->bcandle=$request->bigcandlesqty;
        $cake_customisations->scandle=$request->smallcandlesqty;
        $cake_customisations->name=$request->name;
        $cake_customisations->email=$request->email;
        $cake_customisations->phone=$request->phone;
        $cake_customisations->billaddress=$request->address;
        $cake_customisations->size = $request->cake_size;

        if (!$request->hasFile('photo')) {
            return redirect()->back()->with('error', 'No file uploaded.');
        }

        $request->validate([
            'photo' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('photo');
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('images', $fileName, 'public');
        $cake_customisations->photo = 'storage/'.$path;


        $cake_customisations->status='pending';

        $fixedPrice = 88.80;
        $cake_customisations->price = $fixedPrice;
      
        $cake_customisations->save();

        Mail::to($cake_customisations->email)->send(new CakeCusReceipt($cake_customisations));
    
        return redirect()->back()->with('success', 'Order Placed Successfully!');
    }
    
}
