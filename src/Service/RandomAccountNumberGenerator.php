<?php

namespace App\Service;

class RandomAccountNumberGenerator
{
    public function generateAccountNumber(): string
    {
        $accountNumber = '';
        for ($i = 0; $i < 10; $i++) {
            $accountNumber .= mt_rand(0, 9);
        }
        return $accountNumber;
    }
}

?>
