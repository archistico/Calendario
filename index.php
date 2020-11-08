<?php
require 'vendor/autoload.php';

// ----------------------
//   FAT FREE FRAMEWORK
// ----------------------

$f3 = \Base::instance();
$f3->set('CACHE', true);
$f3->set('DEBUG', 3);

// ----------------------
//         ROUTE
// ----------------------

$f3->route('GET @home: /', '\App\Controllers\Calendario->Homepage');
$f3->route('GET @pdf: /pdf/@anno', '\App\Controllers\Calendario->Pdf');

$f3->run();
