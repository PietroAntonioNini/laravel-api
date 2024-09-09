<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use App\Models\GoogleToken;

class GoogleController extends Controller
{
    /**
     * Handle Google Drive OAuth callback and store tokens in the database.
     */
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
                // Salva il refresh token e l'access token nel database
                $refreshToken = $token['refresh_token'];

                GoogleToken::updateOrCreate(
                    ['token_type' => 'google_drive'],  // Token tipo identificativo
                    [
                        'access_token' => $token['access_token'],   // Nuovo access token
                        'refresh_token' => $refreshToken            // Refresh token
                    ]
                );

                return redirect()->route('dashboard')->with('success', 'Google Drive collegato con successo!');
            } else {
                return redirect()->route('dashboard')->with('error', 'Refresh token non trovato.');
            }
        }

        // Gestisci eventuali errori durante l'autenticazione
        return redirect()->route('dashboard')->with('error', 'Autenticazione Google Drive fallita.');
    }

    /**
     * Get a valid access token using the stored refresh token.
     */
    public function getAccessToken()
    {
        // Recupera il token dal database
        $token = GoogleToken::where('token_type', 'google_drive')->first();

        if ($token) {
            $client = new Google_Client();
            $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
            $client->setAccessToken(['refresh_token' => $token->refresh_token]);

            // Ottieni un nuovo access token usando il refresh token
            $newAccessToken = $client->fetchAccessTokenWithRefreshToken();

            // Aggiorna l'access_token nel database
            $token->update(['access_token' => $newAccessToken['access_token']]);

            return $newAccessToken['access_token'];
        }

        return null; // Se non è disponibile un token valido
    }

    /**
     * Upload a file to Google Drive using the access token.
     */
    public function uploadFileToDrive($filePath)
    {
        $accessToken = $this->getAccessToken();

        if ($accessToken) {
            $client = new Google_Client();
            $client->setAccessToken($accessToken);

            $driveService = new \Google_Service_Drive($client);
            $file = new \Google_Service_Drive_DriveFile();
            $file->setName(basename($filePath));

            $content = file_get_contents($filePath);
            $driveService->files->create($file, [
                'data' => $content,
                'mimeType' => mime_content_type($filePath),
                'uploadType' => 'multipart'
            ]);

            return 'File caricato con successo su Google Drive!';
        }

        return 'Impossibile ottenere un access token valido.';
    }
}