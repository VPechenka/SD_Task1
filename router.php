<?php

$url = $_SERVER['REQUEST_URI'];

if (preg_match('#^/$#', $url, $params)) {
    include 'index.php';
} else {
    include 'redirect.php';
}