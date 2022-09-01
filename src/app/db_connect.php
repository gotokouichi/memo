<?php
class DbAccess
{
  const DB_NAME = 'memo';
  const HOST = 'mysql';
  const UTF = 'utf8';
  const USER = 'root';
  const PASS = 'password';

  protected $pdo;

  public function __construct()
  {
    $dsn  = "mysql:host=" .self::HOST. "; dbname=" .self::DB_NAME. ";charset=" .self::UTF;
    $user = self::USER;
    $pass = self::PASS;
    try {
      $this->pdo = new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.SELF::UTF));
    } catch(Exception $e) {
      echo 'DB接続エラー '.$e->getMessage;
      die();
    }
  }
  
  public function ResisterNewPost($input_title, $input_content)
  {
    $sql = "INSERT INTO pages (title, content, created_at) VALUES (:title, :content, now())";
    $statement = $this->pdo->prepare($sql);
    $statement->bindValue(':title', $input_title, PDO::PARAM_STR);
    $statement->bindValue(':content', $input_content, PDO::PARAM_STR);
    return $statement->execute();
  }

  public function getPostsFromPagesTable()
  {
    $sql = "SELECT id, title, content, created_at FROM pages";
    $statement = $this->pdo->query($sql);
    $statement->execute();
    return $statement->fetchall(PDO::FETCH_ASSOC);
  }

  public function showPost($post_id)
  {
    $sql = "SELECT id, title, content FROM pages WHERE id=(:post_id)";
    $statement = $this->pdo->prepare($sql);
    $statement->bindValue(':post_id', $post_id, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchall(PDO::FETCH_ASSOC);
  }

  public function updatePost($post_id, $input_title, $input_content)
  {
    $sql = "UPDATE pages SET title=(:input_title), content=(:input_content) WHERE id=(:post_id)";
    $statement = $this->pdo->prepare($sql);
    $statement->bindValue(':input_title', $input_title, PDO::PARAM_STR);
    $statement->bindValue(':input_content', $input_content, PDO::PARAM_STR);
    $statement->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    return $statement->execute();
  }

  public function deletePost($post_id) {
    $sql = "DELETE FROM pages WHERE id=(:post_id)";
    $statement = $this->pdo->prepare($sql);
    $statement->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    return $statement->execute();
  }

  public function getPostsFromSearchWord($keyword) {
    $sql = "SELECT id, title, content, created_at FROM pages WHERE concat(title, content) like (:keyword)";
    $statement = $this->pdo->prepare($sql);
    $protected_keyword = '%'.$keyword.'%';
    $statement->bindValue(':keyword', $protected_keyword, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchall(PDO::FETCH_ASSOC);
  }

}