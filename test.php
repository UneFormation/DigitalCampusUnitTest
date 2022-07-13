<?php

require __DIR__ . '/vendor/autoload.php';

$tax = new \App\Entity\Tax(0.1);

$invoice = new \App\Entity\Invoice();
$invoice->setName('David Patiashvili');
$invoice->setTax($tax);
$invoice->setAmount(100);
