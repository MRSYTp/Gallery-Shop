<?php 

namespace App\Services\Payment\Providers;

class IDPayProvider extends BaseProvider
{
    public function pay()
    {
        return 'Paying with IDPay';
    }

    public function verify()
    {
        return 'Verifying with IDPay';
    }
}
