<?php

require __DIR__ . '/../../vendor/autoload.php';

use Callkeeper\Callkeeper;

echo '３秒間に３回'.PHP_EOL;

$keeper = new Callkeeper(3, 3000);

for($i=0; $i<10; $i++) {
    $keeper->timeKeep();

    echo $i.' '.microtime() . PHP_EOL;
}

echo '１秒に２回（一秒sleep）'.PHP_EOL;

$keeper = new Callkeeper(2, 100);

for($i=0; $i<5; $i++) {
    $keeper->timeKeep();
    sleep(1);

    echo $i.' '.microtime() . PHP_EOL;
}
