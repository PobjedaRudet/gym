<?php
// Obriši ovaj fajl nakon što dobiješ informacije!
echo '<pre>';
echo 'Document root: ' . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo 'Artisan path: ' . realpath($_SERVER['DOCUMENT_ROOT'] . '/../artisan') . "\n";
echo 'Laravel root: ' . realpath($_SERVER['DOCUMENT_ROOT'] . '/..') . "\n";
echo 'PHP binary: ' . PHP_BINARY . "\n";
echo '</pre>';
