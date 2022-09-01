<?php
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=memo; charset=utf8',
    $dbUserName,
    $dbPassword
);
//検索機能に関する
//order は45行目付近のラジオボタンのvalueのこと
if (isset($_GET['order'])) {
    $direction = $_GET['order'];
} else {
    $direction = 'desc';
}


// 曖昧検索
if (isset($_GET['search'])) {
    $title = '%' . $_GET['search'] . '%';
    $content = '%' . $_GET['search'] . '%';
} else {
    $title = '%%';
    $content = '%%';
}

// where どこのカラム
// LIKE あいまい検索 =の場合は完全一致
// ORDER BY 〜　idを降順かどっちかで取得する
$sql = "SELECT * FROM pages WHERE title LIKE :title OR content LIKE :content ORDER BY id $direction";
$statement = $pdo->prepare($sql);
$statement->bindValue(':title', $title, PDO::PARAM_STR);
$statement->bindValue(':content', $content, PDO::PARAM_STR);
$statement->execute();
$pages = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<?php
// 表示関係のこと、レスポンシブデザイン関連<head>タグのところ
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>top画面</title>
</head>

<body>
  <div>
    <div>
      <form action="index.php" method="get">
        <div>
          <input name="search" type="text" value="<?php echo $_GET['search'] ??
              ''; ?>" placeholder="キーワードを入力" />
        </div>
        <div>
          <label>
            <input type="radio" name="order" value="desc" class="">
            <span>新着順</span>
          </label>
          <label>
            <input type="radio" name="order" value="asc" class="">
            <span>古い順</span>
          </label>
        </div>
        <button type="submit">送信</button>
      </form>
    </div>
    <div>
      <a href="./create.php">メモを追加</a><br>
    </div>
    <div>
      <table border="1">
        <tr>
          <th>タイトル</th>
          <th>内容</th>
          <th>作成日時</th>
          <th>編集</th>
          <th>削除</th>
        </tr>
        <?php foreach ($pages as $page): ?>
          <tr>
            <td><?php echo $page['title']; ?></td>
            <td><?php echo $page['content']; ?></td>
            <td><?php echo $page['created_at']; ?></td>
            <?php //./edit.php?id=　この書き方をするとidをget送信できる　 ?>
            <td><a href="./edit.php?id=<?php echo $page['id']; ?>">編集</a></td>
            <td><a href="./delete.php?id=<?php echo $page[
                'id'
            ]; ?>">削除</a></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</body>

</html>