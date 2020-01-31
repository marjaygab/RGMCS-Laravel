<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Dropbox\Client;
class DropBoxAPIController extends Controller
{
    public function __construct($accessToken = null)
    {
        if ($accessToken == null) {
            $accessToken = env('DROPBOX_API_V2_ACCESS_TOKEN');
        }

        $client = new Client($accessToken);

        return $client;
    }

}
