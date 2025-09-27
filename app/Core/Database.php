<?php
namespace App\Core;

use PDO, Exception, PDOException;
use RuntimeException;

class Database {
  private $connect;
  public function __construct() {
    try {
      $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8;",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ];
      $dsn_template = "%s:host=%s;port=%s;dbname=%s";
      $dsn = sprintf($dsn_template, $_ENV["DB_DRIVER"], $_ENV["DB_HOST"], $_ENV["DB_PORT"], $_ENV["DB_DB"]);
      $this->connect = new PDO($dsn, $_ENV["DB_USER"], $_ENV["DB_PASS"], $options);
    } catch (Exception $ex) {
      echo "Lỗi kết nối: ".$ex->getMessage();
      exit();
    }
  }

  public function getAll($sql, $params = []) {
    try {
      $stm = $this->connect->prepare($sql);
      $stm->execute($params);
      return $stm->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
      echo "Error: {$ex->getMessage()}<br>";
      return false;
    }
  }

  public function countRows($sql, $params = []) {
    try {
      $stm = $this->connect->prepare($sql);
      $stm->execute($params);
      return $stm->rowCount();
    } catch (PDOException $ex) {
      echo "Error: {$ex->getMessage()}<br>";
      return false;
    }
  }

  public function getOne($sql, $params = []) {
    try {
      $stm = $this->connect->prepare($sql);
      $stm->execute($params);
      return $stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
      echo "Error: {$ex->getMessage()}<br>";
      return false;
    }
  }

  public function lastID() {
    try {
      return $this->connect->lastInsertId();
    } catch (PDOException $ex) {
      echo "Error: {$ex->getMessage()}<br>";
      return false;
    }
  }

  public function insert($table, $data) {
    $keys = array_keys($data);
    $fields = implode(", ", array_map(fn ($key) => "`{$key}`", $keys));
    $places = ":".implode(",:", $keys);

    try {
      $sql = "INSERT INTO `$table` ($fields) VALUES ($places)";
      $stm = $this->connect->prepare($sql);
      return $stm->execute($data);
    } catch (PDOException $ex) {
      throw new RuntimeException("Error: ", 0, $ex);
    }
  }

  public function update(string $table, array $data, string $condition = "", array $params_condition = []) {
    $fields = implode(", ", array_map(fn ($key) => "`{$key}` = :{$key}", array_keys($data)));
    $sql = $condition ? "UPDATE `$table` SET $fields WHERE $condition" : "UPDATE $table SET $fields";

    try {
      $stm = $this->connect->prepare($sql);
      $all_params = array_merge($data, $params_condition);
      return $stm->execute($all_params);
    } catch (PDOException $ex) {
      echo "Lỗi kết nối: ".$ex->getMessage();
      return false;
    }
  }

  public function delete($table, $condition = "", $params_condition = []) {
    $sql = $condition ? "DELETE FROM $table WHERE $condition" : "DELETE FROM $table";

    try {
      $stm = $this->connect->prepare($sql);
      return $stm->execute($params_condition);
    } catch (PDOException $ex) {
      echo "Lỗi kết nối: ".$ex->getMessage();
      return false;
    }
  }
}