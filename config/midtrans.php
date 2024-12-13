<?php  

return [  
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', 'G527554517'),  
    'client_key'  => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-SSC80uMC2Ywv3XEX'),  
    'server_key'  => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-XkhHqR1HE40pw8yrl_C3fMe3'),  

    'is_production' => false, // Ubah ke true untuk mode live  
    'is_sanitized'  => true,  
    'is_3ds'        => true, // Gunakan 3D Secure untuk keamanan  
];