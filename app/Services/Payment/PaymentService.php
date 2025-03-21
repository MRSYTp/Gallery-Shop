<?php

namespace App\Services\Payment;

use App\Services\Payment\Contracts\RequestInterface;
use App\Services\Payment\Exeptions\ProviderNotFoundExeption;

class PaymentService
{
    public const IDPAY = 'IDPayProvider';
    public const ZARINPAL = 'ZarinpalProvider';


    public function __construct(private string $providerName , private RequestInterface $request){}
    


    public function pay()
    {
        $provider = $this->findProvider();
        return $provider->pay();
    }

    private function findProvider(){
        $baseNamespace = 'App\\Services\\Payment\\Providers';
        $providerClass = $baseNamespace . '\\' . $this->providerName;
        if(!class_exists($providerClass)){
            throw new ProviderNotFoundExeption('Provider not found');
        }
        return new $providerClass($this->request);
    }
    
}

