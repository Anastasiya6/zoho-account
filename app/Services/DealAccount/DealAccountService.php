<?php

namespace App\Services\DealAccount;

use App\Services\ZohoApi\ZohoCrmApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DealAccountService
{
    protected $messages = array();

    public function store(Request $request): string
    {
        $zohoApi = new ZohoCrmApi();

        $account = $this->createAccount($request,$zohoApi);

        if($account){

            $deal = $this->createDeal($request,$zohoApi);

            $this->messages[] = "Deal - " . $deal['data'][0]['message']??"";

        }

        return implode(' | ', $this->messages);

    }

    public function createAccount(Request $request,ZohoCrmApi $zohoApi)
    {
        $accountData = [
            'data' => [
                [
                    'Account_Name' => $request->accountName,
                    'Website' => $request->accountWebsite,
                    'Phone' => $request->accountPhone,
                ],
            ],
        ];

        $response = $zohoApi->createAccount($accountData);

        $this->messages[] = "Account - " . $response['data'][0]['message']??"";

        return $response['data'][0]['code'] == 'SUCCESS';

    }

    public function createDeal(Request $request,ZohoCrmApi $zohoApi)
    {
        $dealData = [
            'data' => [
                [
                    'Deal_Name' => $request->dealName,
                    'Stage' => $request->dealStage,
                    'Account_Name' => $request->accountName,
                ],
            ],
        ];

        return $zohoApi->createDeal($dealData);

    }
}
