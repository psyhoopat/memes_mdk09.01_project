<?php 

require_once "lib/mysqli.php";

$result = get_meme();
$break = 0;

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing</title>
    <link rel="stylesheet" href="/static/styles.css">
</head>
<body>
<?php include_once("templates/header.php"); ?>
<main>
    <div>
        <div class="title">
            <h1>Мемасный сайт</h1>
        </div>
    </div>

    <div>
        <?php if($result->num_rows == 0): ?>
            <p>Мемов нет</p>
        <?php endif; ?>
        <div class="cards">
            <?php if($result->num_rows > 0): ?>
                <?php foreach($result as $value): ?>
                    <div class="card">
                        <div><img class="img" src="<?= $value['img'] ?>" alt="img"></div>
                        <h3><?= $value['name'] ?></h3>
                        <p><?= $value['description'] ?></p>
                    </div>
                    <?php $break++; ?>
                    <?php if($break == 3) { break; } ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div>
        <a href="/watch-meme.php" style="margin-top: 30px;">Смотреть мемы без регистрации</a>
    </div>
</main>
</body>
</html>