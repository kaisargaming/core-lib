<?php
require __DIR__ . '/../vendor/autoload.php';

use KGaming\Core\Utils;

// Get formatted time with Hong Kong timezone
echo Utils::getTime('d/m H:i', 'Asia/Hong_Kong') . PHP_EOL;

// Generate UUIDv1 String
echo Utils::uid1() . PHP_EOL;

// Generate UUIDv5 Namespace String
echo Utils::uid5('hello.com') . PHP_EOL;
