<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;

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

            // Salva il token di aggiornamento nel file .env o nel database
            $refreshToken = $token['refresh_token'];

            // Aggiorna il .env o memorizza il refresh token in modo sicuro
            // Puoi usare un pacchetto per modificare dinamicamente il file .env oppure memorizzarlo in un DB
            // Per esempio:
            file_put_contents(base_path('.env'), 'GOOGLE_DRIVE_REFRESH_TOKEN='.$refreshToken.PHP_EOL, FILE_APPEND);

            return redirect()->route('dashboard')->with('success', 'Google Drive collegato con successo!');
        }

        // Se c'è un errore
        return redirect()->route('dashboard')->with('error', 'Autenticazione Google Drive fallita.');
    }
}