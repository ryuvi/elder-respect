<?php
return array( 
    '/' => array('HomeController', 'index'),

    // Auth
    '/login' => array('AuthController', 'login'),
    '/register' => array('AuthController', 'register'),
    '/logout' => array('AuthController', 'logout'),
    '/forgot' => array('AuthController', 'forgot'),

    // Main
    '/results' => array("HomeController", "results"),

    // Carros
    '/carro' => array("CarrosController", "index"),

    // Admin
    '/admin' => array('AdminController', 'index'),

    // Cidades
    '/admin/cidades' => array('AdminController', 'cidades'),
    '/admin/cidades/add' => array('AdminController', 'cidadesAdd'),
    '/admin/cidades/delete' => array('AdminController', 'cidadesDelete'),

    // Vendedores
    '/admin/vendedores' => array('AdminController', 'vendedores'),
    '/admin/vendedores/add' => array('AdminController', 'vendedoresAdd'),
    '/admin/vendedores/reset-password' => array('AdminController', 'vendedoresResetPassword'),

    // Carros
    '/admin/carros' => array('AdminController', 'carros'),
    '/admin/carros/add' => array('AdminController', 'carrosAdd'),
);
