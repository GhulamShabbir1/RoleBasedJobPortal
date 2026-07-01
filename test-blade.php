<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $compiler = app('blade.compiler');
    $path = __DIR__ . '/resources/views/components/error-notification.blade.php';
    $compiled = $compiler->compileString(file_get_contents($path));
    echo "Compiled successfully:\n";
    echo $compiled;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
