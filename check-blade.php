<?php
$files = glob(__DIR__ . '/resources/views/**/*.blade.php');
foreach ($files as $file) {
    $content = file_get_contents($file);
    $stack = [];
    $lines = explode("\n", $content);
    foreach ($lines as $i => $line) {
        // Check for opening directives
        if (preg_match('/@(if|elseif|foreach|for|while|switch)\b/', $line, $matches)) {
            $stack[] = ['type' => $matches[1], 'line' => $i + 1];
        }
        // Check for closing directives
        if (preg_match('/@(endif|endforeach|endfor|endwhile|endswitch)\b/', $line, $matches)) {
            if (!empty($stack)) {
                array_pop($stack);
            }
        }
    }
    if (!empty($stack)) {
        echo "File: $file\n";
        foreach ($stack as $item) {
            echo "  Unclosed @{$item['type']} on line {$item['line']}\n";
        }
    }
}
