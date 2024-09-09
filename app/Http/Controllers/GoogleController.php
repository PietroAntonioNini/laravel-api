<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use App\Models\GoogleToken;

class GoogleController extends Controller
{
    public function handleGoogleDriveCallback(Request $request)
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_DRIVE_REDIRECT_URI'));
        $client->setAccessType('offline'); // Permette di ottenere il refresh token
        $client->setScopes(['https://www.googleapis.com/auth/drive.file']);

        if ($request->has('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($request->input('code'));

            if (isset($token['refresh_token'])) {
                $refreshToken = $token['refresh_token'];
                
                // Debug: Visualizza il refresh token
                dd($token);
                
                // Salva il token nel database
                GoogleToken::updateOrCreate(
                    ['token_type' => 'google_drive'],
                    [
                        'access_token' => $token['access_token'],
                        'refresh_token' => $refreshToken
                    ]
                );
            
                return redirect()->route('dashboard')->with('success', 'Google Drive collegato con successo!');
            } else {
                // Debug: Mostra un errore se il refresh token non è presente
                dd('Refresh token non trovato', $token);
            }
        }

        // Se c'è un errore
        return redirect()->route('dashboard')->with('error', 'Autenticazione Google Drive fallita.');
    }
}