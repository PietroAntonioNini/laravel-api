<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewContact;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function store(Request $request) {

        // validazione
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required|email',
            'message' => 'required'
        ], [
            'name.required' => "Devi inserire il tuo nome",
            'address.required' => "Devi inserire la tua email",
            'address.email' => "Devi inserire una mail corretta",
            'message.required' => "Devi inserire un messaggio",
        ]);

        if($validator->fails()) {
            // restituiamo un oggetto json con il messaggio di errore
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        // salvataggio nel db
        $newLead = new Lead();
        $newLead->fill($request->all());
        $newLead->save();


    
        // invio della mail
        Mail::to('inseriscilatuamail@gmail.com')->send(new NewContact($newLead));

        //restituisco un json true
        return response()->json([
            'success' => true,
            'message' => 'Richiesta di Contatto inviato correttamente',
            'request' => $request->all(),
        ]);

        
    }
}
