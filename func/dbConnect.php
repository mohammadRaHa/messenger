<?php

/**
 * Developed by PhpStorm.
 * Date: 30/06/2016
 * Time: 02:36
 * Version: 2.1
 */
class dataBase{
  private $db;

  //=>=>=>=>=>=>=>=>=>=>=>=>=>=> __construct  <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=

  function __construct($hostName, $dbName, $userName, $passWord)
  {
    try {
      $this->db = new PDO("mysql:dbname={$dbName};host={$hostName}",
        $userName,
        $passWord);
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->db->exec("set names utf8");
    }
    catch(PDOException $e){
      return array("errStatus" => true, "errMessage" => $e->getMessage(), "errCode" => $e->getCode());
    }
  }

  //=>=>=>=>=>=>=>=>=>=>=>=>=>=>  Read  ROWs  <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=

  public function read ($tbl, $clmns, $where = array(), $op = 'AND', $sortBy = "", $count = "25")
  {
    ########### $where array =[colomn1 : value, colomn2 : value] ###########
    try{
      $query = "SELECT {$clmns} FROM {$tbl}";
      $stmt = $this->db->query($query);
      if (!empty($where)){
        $query .= " WHERE ";
        $bind = [];
        foreach ($where as $key => $value){
          $query .= "`{$key}` {$value["op"]} :{$key}";
          $bind[":{$key}"] = $value["value"];
          if ($value != end($where)){
            $query .= " {$op} ";
          }
        }
        if (!empty($sortBy)){
          $query .= " ORDER BY {$sortBy} ";
        }
        if ($count != ""){
          $query .= " LIMIT {$count}";
        }
        $stmt = $this->db->prepare($query);
        $stmt->execute($bind);
      }
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $rows;
    } catch (PDOException $e){
      return array("errStatus" => true, "errMessage" => $e->getMessage(), "errCode" => $e->getCode());
    }
  }

  //=>=>=>=>=>=>=>=>=>=>=>=>=>=>  WRITE  ROW  <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=

  public function write($tbl, $values)
  {
    try {
      $query = "INSERT INTO {$tbl} ";
      $col = $val = "(";
      $bind = [];
      foreach ($values as $key => $value){
        $col .= "{$key}";
        $val .= ":{$key}";
        $bind[":{$key}"] = $value;
        if ($value != end($values)){
          $col .= ", ";
          $val .= ", ";
        }
      }
      $col .= ")";
      $val .= ")";
      $query .= "{$col} VALUES {$val}";
      $stmt = $this->db->prepare($query);
      $stmt->execute($bind);
      return $stmt;
    } catch (PDOException $e){
      return array("errStatus" => true, "errMessage" => $e->getMessage(), "errCode" => $e->getCode());
    }

  }

  //=>=>=>=>=>=>=>=>=>=>=>=>=>=>  UPDATE ROW  <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=

  public function edit($tbl, $values, $where, $op)
  {
    try {
      $query = "UPDATE {$tbl} SET ";
      $bind = [];
      foreach ($values as $key => $value) {
        $query .= "`{$key}` = :{$key} ";
        $bind[":{$key}"] = $value;
        if ($value != end($values)) {
          $query .= ", ";
        }
      }
      $query .= "WHERE ";
      foreach ($where as $key => $value) {
        $query .= "`{$key}` {$value["op"]} :{$key}";
        $bind[":{$key}"] = $value["value"];
        if ($value != end($where)) {
          $query .= "{$op} ";
        }
      }
      $stmt = $this->db->prepare($query);
      $stmt->execute($bind);
      return $stmt;
    } catch (PDOException $e) {
      return array("errStatus" => true, "errMessage" => $e->getMessage(), "errCode" => $e->getCode());
    }
  }

  //=>=>=>=>=>=>=>=>=>=>=>=>=>=>  DELETE ROW  <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=

  public function delete($tbl, $where, $op)
  {
    try {
      $query = "DELETE FROM {$tbl} WHERE ";
      $bind = [];
      foreach ($where as $key => $value){
        $query .= "`{$key}` {$value["op"]} :{$key}";
        $bind[":{$key}"] = $value["value"];
        if ($value != end($where)){
          $query .= " {$op} ";
        }
      }
      $stmt = $this->db->prepare($query);
      $stmt->execute($bind);
      return $stmt;
    } catch (PDOException $e){
      return array("errStatus" => true, "errMessage" => $e->getMessage(), "errCode" => $e->getCode());
    }
  }

  //=>=>=>=>=>=>=>=>=>=>=>=>=>=> CREATE TBL DB<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=

  public function createTable($tbl, $clmns)
  {
    return "Sorry, this methude in no ready yet.";
  }
}
?>
