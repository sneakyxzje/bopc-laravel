<?php
$content = file_get_contents('resources/views/products/old_detail.blade.php');

// Perform replacements
$content = str_replace('#0e4d3d', 'primary', $content);
$content = str_replace('green-900', 'primary', $content);
$content = str_replace('red-400', 'primary/40', $content);
$content = str_replace('red-50', 'primary/5', $content);
$content = str_replace('red-600', 'primary', $content);
$content = str_replace('red-500', 'primary', $content);

// Fix potential [primary] from previous failed attempt
$content = str_replace('[primary]', 'primary', $content);

// Ensure Outfit font is prominent if needed (though global font-outfit should handle it)
// But let's add a wrapper or check for font-sans/font-bold etc.
// The user just said "font", so I'll assume they want the new font applied.

file_put_contents('resources/views/products/detail.blade.php', $content);
echo "Refactored detail.blade.php successfully.\n";
