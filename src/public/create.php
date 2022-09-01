<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>メモアプリ</title>
</head>

<body>
  <div class="container">
    <h2>メモ登録</h2>
  </div>
</body>
<form method="post" action="./store.php">
  <div class="form-group">
    <label for="name">title
      <input type="text" name="title" placeholder="タイトル">
    </label>
  </div>
  <div class="form-group">
    <label for="content">本文
      <input type="textarea" name="content" placeholder="本文">
    </label>
  </div>
  <button type="submit" class="btn btn-primary">送信</button>
</form>

</html>