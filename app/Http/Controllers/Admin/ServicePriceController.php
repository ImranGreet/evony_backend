<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicePrice;
use Illuminate\Http\Request;

class ServicePriceController extends Controller
{
    public function servicePriceList(){
        $servicesPrices = ServicePrice::all();

        return response()->json([
            "homeImages" => $servicesPrices
        ]);
    }

    
    public function createService(Request $request){
        
        $request->validate([
            'service_title' => ['string', 'max:255'],
            'service_price' => [  'required|numeric|between:1,99999999999999'],
        ]);

        $servicesPrices = new ServicePrice();
        $servicesPrices->service_title = $request->service_title;
        $servicesPrices->service_price = $request->service_price;
       

        $servicesPrices->save();

        return response()->json([
            "message" => "HomeImage Created Successfully!"
        ]);
    }

    public function editService($id)
    {
        $service = ServicePrice::findOrFail($id);
        return response()->json($service);
    }

    public function updateService(Request $request, $id)
    {
        $service = ServicePrice::findOrFail($id);

        $request->validate([
            'service_title' => ['string', 'max:255'],
            'service_price' => ['required', 'numeric', 'between:1,99999999999999'],
        ]);

        $service->update([
            'service_title' => $request->service_title,
            'service_price' => $request->service_price,
        ]);

        return response()->json([
            "message" => "Service Updated Successfully!"
        ]);
    }


    public function deleteService($id)
    {
        $service = ServicePrice::findOrFail($id);
        $service->delete();

        return response()->json([
            "message" => "Service Deleted Successfully!"
        ]);
    }


}
