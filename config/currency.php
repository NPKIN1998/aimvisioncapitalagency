<?php

return [
    // Base configuration
    'base_currency' => 'KES',
    'base_symbol' => 'KSh',
    'usd_rate' => 0.0078, // 1 KES = 0.0078 USD
    'min_withdrawal_kes' => 100, // Minimum withdrawal in KES

    // Country currency rates (all rates are relative to 1 KES)
    'rates' => [
        'KE' => [
            'name' => 'Kenya',
            'currency' => 'KES',
            'symbol' => 'KSh',
            'rate' => 1,
            'min_amount' => 100, // Same as base
            'phone_code' => '+254',
            'phone_regex' => '/^\+?254[17]\d{8}$/'
        ],
        'UG' => [
            'name' => 'Uganda',
            'currency' => 'UGX',
            'symbol' => 'USh',
            'rate' => 27.79,
            'min_amount' => 2779, // 100 KES equivalent
            'phone_code' => '+256',
            'phone_regex' => '/^\+?256\d{9}$/'
        ],
        'TZ' => [
            'name' => 'Tanzania',
            'currency' => 'TZS',
            'symbol' => 'TSh',
            'rate' => 19.89,
            'min_amount' => 1989,
            'phone_code' => '+255',
            'phone_regex' => '/^\+?255\d{9}$/'
        ],
        'US' => [
            'name' => 'United States',
            'currency' => 'USD',
            'symbol' => '$',
            'rate' => 0.0078,
            'min_amount' => 0.78,
            'phone_code' => '+1',
            'phone_regex' => '/^\+1\d{10}$/'
        ],
        'BI' => [
            'name' => 'Burundi',
            'currency' => 'BIF',
            'symbol' => 'FBu',
            'rate' => 22.82,
            'min_amount' => 2282,
            'phone_code' => '+257',
            'phone_regex' => '/^\+?257\d{8}$/'
        ],
        'RW' => [
            'name' => 'Rwanda',
            'currency' => 'RWF',
            'symbol' => 'FRw',
            'rate' => 11.17,
            'min_amount' => 1117,
            'phone_code' => '+250',
            'phone_regex' => '/^\+?250\d{9}$/'
        ],
        'ZM' => [
            'name' => 'Zambia',
            'currency' => 'ZMW',
            'symbol' => 'ZK',
            'rate' => 0.18,
            'min_amount' => 18,
            'phone_code' => '+260',
            'phone_regex' => '/^\+?260\d{9}$/'
        ],
        'SS' => [
            'name' => 'South Sudan',
            'currency' => 'SSP',
            'symbol' => 'SS£',
            'rate' => 34.98,
            'min_amount' => 3498,
            'phone_code' => '+211',
            'phone_regex' => '/^\+?211\d{9}$/'
        ],
        'GH' => [
            'name' => 'Ghana',
            'currency' => 'GHS',
            'symbol' => 'GH₵',
            'rate' => 0.081,
            'min_amount' => 8.1,
            'phone_code' => '+233',
            'phone_regex' => '/^\+?233\d{9}$/'
        ],
        'SC' => [
            'name' => 'Seychelles',
            'currency' => 'SCR',
            'symbol' => 'SR',
            'rate' => 0.11,
            'min_amount' => 11,
            'phone_code' => '+248',
            'phone_regex' => '/^\+?248\d{6}$/'
        ],
        'MG' => [
            'name' => 'Madagascar',
            'currency' => 'MGA',
            'symbol' => 'Ar',
            'rate' => 34.36,
            'min_amount' => 3436,
            'phone_code' => '+261',
            'phone_regex' => '/^\+?261\d{9}$/'
        ],
        'MW' => [
            'name' => 'Malawi',
            'currency' => 'MWK',
            'symbol' => 'MK',
            'rate' => 13.47,
            'min_amount' => 1347,
            'phone_code' => '+265',
            'phone_regex' => '/^\+?265\d{9}$/'
        ],
        'ET' => [
            'name' => 'Ethiopia',
            'currency' => 'ETB',
            'symbol' => 'Br',
            'rate' => 1.07,
            'min_amount' => 107,
            'phone_code' => '+251',
            'phone_regex' => '/^\+?251\d{9}$/'
        ],
        'ER' => [
            'name' => 'Eritrea',
            'currency' => 'ERN',
            'symbol' => 'Nfk',
            'rate' => 0.116285,
            'min_amount' => 11.63,
            'phone_code' => '+291',
            'phone_regex' => '/^\+?291\d{7}$/'
        ],
        'MU' => [
            'name' => 'Mauritius',
            'currency' => 'MUR',
            'symbol' => '₨',
            'rate' => 0.36,
            'min_amount' => 36,
            'phone_code' => '+230',
            'phone_regex' => '/^\+?230\d{7,8}$/'
        ],
        'DJ' => [
            'name' => 'Djibouti',
            'currency' => 'DJF',
            'symbol' => 'Fdj',
            'rate' => 1.38,
            'min_amount' => 138,
            'phone_code' => '+253',
            'phone_regex' => '/^\+?253\d{6}$/'
        ],
        'KM' => [
            'name' => 'Comoros',
            'currency' => 'KMF',
            'symbol' => 'CF',
            'rate' => 3.35,
            'min_amount' => 335,
            'phone_code' => '+269',
            'phone_regex' => '/^\+?269\d{7}$/'
        ],
        'MZ' => [
            'name' => 'Mozambique',
            'currency' => 'MZN',
            'symbol' => 'MT',
            'rate' => 0.50,
            'min_amount' => 50,
            'phone_code' => '+258',
            'phone_regex' => '/^\+?258\d{8,9}$/'
        ],
        'SO' => [
            'name' => 'Somalia',
            'currency' => 'SOS',
            'symbol' => 'Sh.So.',
            'rate' => 4.43,
            'min_amount' => 443,
            'phone_code' => '+252',
            'phone_regex' => '/^\+?252\d{7,8}$/'
        ],

        // ✅ New: Australia
        'australia' => [
            'name' => 'Australia',
            'currency' => 'AUD',
            'symbol' => 'A$',
            'rate' => 0.012, // Approx. 1 KES = 0.012 AUD
            'min_amount' => 1.2, // Equivalent of 100 KES
            'phone_code' => '+61',
            'phone_regex' => '/^\+?61\d{9}$/'
        ],

        // ✅ New: South Africa
        'south-africa' => [
            'name' => 'South Africa',
            'currency' => 'ZAR',
            'symbol' => 'R',
            'rate' => 0.14, // Approx. 1 KES = 0.14 ZAR
            'min_amount' => 14, // Equivalent of 100 KES
            'phone_code' => '+27',
            'phone_regex' => '/^\+?27\d{9}$/'
        ],
        // Nigeria
        'nigeria' => [
            'name' => 'Nigeria',
            'currency' => 'NGN',
            'symbol' => '₦',
            'rate' => 6.2, // Approx. 1 KES = 6.2 NGN (update to live rate if needed)
            'min_amount' => 620, // Equivalent of 100 KES
            'phone_code' => '+234',
            'phone_regex' => '/^\+?234\d{10}$/'
        ],
    ],

    // Default settings
    'default_country' => 'KE',
    'default_currency' => 'KES',
    'default_symbol' => 'KSh',
];
