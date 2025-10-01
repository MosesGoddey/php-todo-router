<?php
echo "<h1>SUCCESS! The folder is accessible.</h1>";
echo "<p>Current directory: " . __DIR__ . "</p>";
echo "<p>Files in this directory:</p>";
echo "<pre>";
print_r(scandir('.'));
echo "</pre>";
?>