<?php

namespace App\Services\Payment\Providers;

use App\Services\Payment\Contracts\PayableInterface;
use App\Services\Payment\Contracts\VerifiableInterface;
use App\Services\Payment\Contracts\RequestInterface;

abstract class BaseProvider implements PayableInterface, VerifiableInterface
{
    public function __construct(private RequestInterface $request){}
    
}

