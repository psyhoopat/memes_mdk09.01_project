<?php

require_once "lib/setting.php";
require_once "lib/mysqli.php";
require_once "lib/utils.php";

$url = $_SESSION['server_url']."form.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        "name" => $_POST['name'] ?? '',
        "desc" => $_POST['description'] ?? '',
        "file_tmp" => $_FILES['file']['tmp_name'],
        "file_path" => $_FILES['file']['full_path'],
        "file_size" => $_FILES['file']['size'],
        "file_type" => $_FILES['file']['type'],
    ];

    if( 
        empty($data['name']) ||
        empty($data['desc']) ||
        empty($data['file_tmp']) 
     ) {
        $_SESSION['error'] = 'Заполните все поля';
        header("Location: $url");
        exit;
    }

    $date = date("Y-m-d");
    $time = date("H-i-s");
    $random = rand(100, 200);
    $path = md5($_FILES['file']['full_path']);

    $fileExt = strtolower(pathinfo($data['file_path'], PATHINFO_EXTENSION));
    $destination = "static/img/($random)-$date-($time)-$path.$fileExt";

    $is_upload = write_upload_file(
        $data['file_tmp'], 
        $destination
    );

    if(!$is_upload) {
        $_SESSION['error'] = 'Ошибка на сервере, невозможно загрузить файл';
        header("Location: $url");
        exit;
    }

    create_post($data['name'], $data['desc'], $destination);
    write_file($data['name'], $data['desc'], $destination);

    $_SESSION['success'] = 'Успешно загружен пост';
    header("Location: $url");

    exit;
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Форма добавления</title>
    <link rel="stylesheet" href="/static/styles.css">
</head>
<body>
<?php include_once("templates/header.php"); ?>
<main>

    <?php echo !empty($_SESSION['error']) ? "<div class='error'>".$_SESSION['error']."</div>" : ''; ?>
    <?php echo !empty($_SESSION['success']) ? "<div class='success'>".$_SESSION['success']."</div>" : ''; ?>

    
    <form action="<?= $url ?>" method="POST" enctype="multipart/form-data">
        <h1>Форма добавления</h1>
        <div>
            <label for="name">Название мема</label>
            <input id="name" class="input" name="name" type="text" placeholder="Название" required/>
        </div>
        <div>
            <label for="description">Описание</label>
            <textarea name="description" class="input" id="description" cols="30" rows="10" placeholder="Описание" required></textarea>
        </div>
        <div>
            <label for="file">Загрузить картинку (png, jpeg, jpg)</label>
            <input id="file" type="file" accept="image/png, image/jpeg" name="file" class="input" required>
        </div>
        <button type="submit">Отправить</button>
        <button type="reset">Сбросить</button>
    </form>

</main>
</body>
</html>

<?php unset($_SESSION['error']); unset($_SESSION['success']); ?>