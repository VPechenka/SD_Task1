<?php

require_once 'db.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $original_url = trim($_POST['url']);

    if ($original_url !== htmlspecialchars($original_url)) {
        $error = "Замечена попытка атаки";
    } else if (!filter_var($original_url, FILTER_VALIDATE_URL)) {
        $error = "Пожалуйста, введите корректный URL";
    } else {
        $href = generate_href();
        $result = save_link($original_url, $href);

        if ($result) {
            $short_url = get_short_url($href);
        } else {
            $error = "Произошла ошибка при сохранении ссылки";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сокращатель ссылок</title>
</head>
<body>
<div>
    <h1>Сократить ссылку</h1>

    <form method="POST">
        <input type="url" name="url" placeholder="Введите URL" required>

        <button type="submit">
            Сократить
        </button>
    </form>

    <?php if (isset($error)): ?>
        <div>
            <?= $error ?>
        </div>
    <?php endif; ?>

    <?php if (isset($short_url)): ?>
        <div>
            Ваша короткая ссылка:
            <a href="<?= $short_url ?>">
                <?= $short_url ?>
            </a>
        </div>
    <?php endif; ?>

</div>

</body>
</html>