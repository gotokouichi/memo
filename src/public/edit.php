<?php
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=memo; charset=utf8',
    $dbUserName,
    $dbPassword
);

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql = "SELECT * FROM pages where id = $id";
$statement = $pdo->prepare($sql);
$statement->execute();
$page = $statement->fetch();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>編集画面</title>
</head>

<body>
  <div class="container">
    <h2>編集</h2>
    <form method="post" action="./update.php">
      <input type="hidden" name="id" value=<?php echo $page['id'] ?>>
      <div class="form-group">
        <label for="name">title
          <input type="text" name="title" value=<?php echo $page['title'] ?>>
        </label>
      </div>
      <div class="form-group">
        <label for="content">本文
          <input type="textarea" name="content" value=<?php echo $page['content'] ?>>
        </label>
      </div>
      <button type="submit" class="btn btn-primary">更新</button>
    </form>
  </div>
</body>

</html>