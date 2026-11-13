<?php

require __DIR__ . '/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__);

$twig = new \Twig\Environment($loader);

echo $twig->render(
    'home.twig',
    ['usuario' => 'Wagner Lima Chimenez']
);
