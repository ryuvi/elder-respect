<?php
spl_autoload_register(function ($class) {
   // Define diretórios onde procurar as classes
    $folders = array(
        __DIR__ . '/../app/controllers/',
        __DIR__ . '/../app/models/',
        __DIR__ . '/../app/helpers/',
        __DIR__ . '/../app/database/'
    );

    foreach ($folders as $folder) {
        $file = $folder . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    // Se não encontrar a classe
    throw new Exception("Classe {$class} não encontrada.");
});
