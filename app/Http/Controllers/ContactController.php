<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Http\Requests\QuoteFormRequest;
use App\Mail\ContactFormMail;
use App\Mail\QuoteFormMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    function email(ContactFormRequest $request)
    {
        // All data is already validated by the form request
        $validatedData = $request->validated();
        
        try {
            // Send email using Laravel's Mail facade
            Mail::to('atencionalcliente@filtroswillybusch.com.pe')
                ->send(new ContactFormMail($validatedData));
                
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'errors' => $e->getMessage()
            ]);
        }
    }

    function quote(QuoteFormRequest $request)
    {
        // Get validated data from the form request
        $validatedData = $request->validated();
        info($validatedData);
        // Process the products list from comma-separated message
        $products = explode(',', $validatedData['message']);
        
        try {
            // Send email using Laravel's Mail facade
            // Note: We're sending to both the customer and company
            Mail::to($validatedData['email'])
                ->cc('atencionalcliente@filtroswillybusch.com.pe')
                ->send(new QuoteFormMail($validatedData));
                
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'error' => $e->getMessage()
            ]);
        }
    }
}
