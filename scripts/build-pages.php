<?php

require __DIR__ . '/../src/vendor/autoload.php';

$outputDir = __DIR__ . '/../build';
$viewsDir = __DIR__ . '/../src/views';

if (is_dir($outputDir)) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($outputDir, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($iterator as $item) {
        $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
    }
} else {
    mkdir($outputDir, 0777, true);
}

$twig = new Twig\Environment(new Twig\Loader\FilesystemLoader($viewsDir));

$pages = [
    'index.html' => ['index.twig', ['usuario' => 'Wagner Lima Chimenez']],
    'sobre.html' => ['sobre.twig', []],
    'contato.html' => ['contato.twig', []],
];

foreach ($pages as $filename => [$template, $context]) {
    $html = $twig->render($template, $context);
    $html = str_replace(['index.php', 'sobre.php', 'contato.php'], ['index.html', 'sobre.html', 'contato.html'], $html);
    file_put_contents($outputDir . '/' . $filename, $html);
}

file_put_contents($outputDir . '/.nojekyll', '');

