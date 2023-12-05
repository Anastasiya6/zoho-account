<?php
namespace App\Services\ZohoApi;

use App\Models\ZohoToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZohoCrmApi
{
    protected $baseUrl;
    protected $access_token;
    protected $refresh_token;
    protected $flag_token;
    protected $client_id;
    protected $client_secret;
    protected $create_date_token;

    public function __construct()
    {
        $this->baseUrl = 'https://www.zohoapis.eu/crm/v2/';

        $zoho_token = ZohoToken::first();

        if($zoho_token){
            $this->access_token = $zoho_token->access_token;
            $this->refresh_token = $zoho_token->refreshToken;
            $this->flag_token = $zoho_token->flag;
            $this->client_id = $zoho_token->client_id;
            $this->client_secret= $zoho_token->client_secret;
            $this->create_date_token = $zoho_token->create_date_token;

            $this->refreshTokenIfNeeded($zoho_token->refresh_token);
        }
    }

    public function refreshTokenIfNeeded($refresh_token)
    {

        if ( $this->flag_token == 0 || now() >= Carbon::parse($this->create_date_token)->addHours(1)  ) {

            try {
                $response = Http::asForm()->post('https://accounts.zoho.eu/oauth/v2/token', [
                    'refresh_token' => $refresh_token,
                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret,
                    'grant_type' => 'refresh_token',
                ]);

                Log::info('Zoho API Response:', ['response' => $response->json()]);
            } catch (\Exception $e) {
                Log::error('Zoho API Request Failed', ['error' => $e->getMessage()]);
            }

            $newToken = $response->json();

            if (isset($newToken['access_token'])) {
                $this->saveToken($newToken['access_token']);
            }

            return $newToken;
        }

        return $refresh_token;
    }

    public function saveToken($newToken)
    {
        $zoho_token = ZohoToken::first();
        if ($zoho_token) {
            $zoho_token->access_token = $newToken;
            $zoho_token->create_date_token = now()->addMinutes(5);
            $zoho_token->flag = 1;
            $zoho_token->save();
            $this->flag_token = 1;
            $this->access_token = $newToken;
        }
    }

    public function createDeal($dealData)
    {
        $url = $this->baseUrl . 'Deals';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->access_token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->withoutVerifying()->post($url, $dealData);

        return $response->json();
    }
    public function createAccount($accountData)
    {
        $accountUrl = $this->baseUrl . 'Accounts';
        $accountResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->access_token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->withoutVerifying()->post($accountUrl, $accountData);

        return $accountResponse->json();
    }

}
