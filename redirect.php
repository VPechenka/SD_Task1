<?php

require_once 'db.php';
require_once 'functions.php';

$href = trim($_SERVER['REQUEST_URI'], '/');

if (!empty($href)) {
    $link = get_link_by_href($href);

    if ($link) {
        increment_click_count($link['id']);

        header("Location: " . $link['original_url']);
        exit;
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "Ссылка не найдена";
    }
}