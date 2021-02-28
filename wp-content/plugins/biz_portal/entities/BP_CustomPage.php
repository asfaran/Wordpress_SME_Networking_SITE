<?php

class BP_CustomPage
{
    const SME = 1;
    const BUSINESS_PARTNER = 2;
    const SERVICE_PROVIDER = 3;
    const INVESTOR = 4;
    const NGOs = 5;

    public static function get_name($code)
    {
        switch ($code) {
            case 1:
                return 'SME';
            case 2:
                return 'BUSINESS_PARTNER';
            case 3:
                return 'SERVICE_PROVIDER';
            case 4:
                return 'INVESTOR';
            case 5:
                return 'NGOs';
        }
    }
}