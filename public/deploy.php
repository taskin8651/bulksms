<?php

// SECURITY: Add your GitHub secret if needed
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'] ?? '';
$secret = ''; // optional

// Go to your project folder
$projectRoot = '/home/smartuni/public_html/businessbarhega.in';

chdir($projectRoot);

// Pull latest code
$output = shell_exec('git pull 2>&1');

echo "<pre>$output</pre>";
