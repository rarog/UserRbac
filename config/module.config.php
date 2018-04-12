<?php
namespace UserRbac;

return [
    'zfc_rbac' => [
        'identity_provider' => Identity\IdentityProvider::class,
        'redirect_strategy' => [
            'redirect_to_route_connected' => 'zfcuser',
            'redirect_to_route_disconnected' => 'zfcuser/login',
            'append_previous_uri' => true,
            'previous_uri_query_key' => 'redirect',
        ],
    ],
    'user_rbac' => [],
];
