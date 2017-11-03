<?php

return [
    'page.pages' => [
        'index'      => 'page::pages.list resource',
        'create'     => 'page::pages.create resource',
        'edit'       => 'page::pages.edit resource',
        'destroy'    => 'page::pages.destroy resource',
        'sitemap'    => 'page::pages.sitemap resource',
        'permission' => 'page::pages.permission resource'
    ],
    'api.page'   => [
        'update'  => 'page::pages.edit resource',
        'destroy' => 'page::pages.destroy resource',
        'get'     => 'page::pages.get resource',
    ]
];
