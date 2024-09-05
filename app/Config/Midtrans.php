<?php

namespace Config;

class Midtrans
{
    public $serverKey;
    public $clientKey;
    public $isProduction = false;

    public function __construct()
    {
        // Get Midtrans keys and environment from .env file
        $this->serverKey = env('CI_SERVER_KEY', 'default_server_key');
        $this->clientKey = env('CI_CLIENT_KEY', 'default_client_key');
    }
}
