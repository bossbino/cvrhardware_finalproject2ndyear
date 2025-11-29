<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

echo "starting test<br>";
require_once __DIR__ . '/inc/db.php';
echo "inc/db.php included OK<br>";
echo "MySQL host info: " . htmlspecialchars($conn->host_info ?? 'no $conn');
