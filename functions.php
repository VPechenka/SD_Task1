<?php
function generate_href()
{
    $href = '';

    $chars = '0123456789abcdefghijklmnopqrstuvwxyz';

    for ($i = 0; $i < 6; $i++) {
        $href .= $chars[rand(0, strlen($chars) - 1)];
    }

    return $href;
}

function save_link($original_url, $href)
{
    global $db;

    $stmt = $db->prepare(
        "INSERT INTO links (original_url, href)
        VALUES (:original_url, :href)"
    );

    $stmt->bindParam(':original_url', $original_url);
    $stmt->bindParam(':href', $href);

    return $stmt->execute();
}

function get_link_by_href($href)
{
    global $db;

    $stmt = $db->prepare(
        "SELECT * 
        FROM links 
        WHERE href = :href
        LIMIT 1"
    );
    $stmt->bindParam(':href', $href);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function increment_click_count($link_id)
{
    global $db;

    $stmt = $db->prepare(
        "UPDATE links 
        SET click_count = click_count + 1,
            last_open_at = CURRENT_TIMESTAMP
        WHERE id = :id"
    );
    $stmt->bindParam(':id', $link_id);

    return $stmt->execute();
}

function get_short_url($href)
{
    $host = $_SERVER['HTTP_HOST'];
    return "http://" . $host . '/' . $href;
}