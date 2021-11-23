<?php


return [
    'email_verification_base_url' => env('EMAIL_VERIFICATION_BASE_URL', "email-verification"),
    'default_expiry' => env('MAGIC_LINK_DEFAULT_EXPIRY', '+1 day')
];
