<?php
/**
 * Created by PhpStorm.
 * User: raha
 * Date: 06/07/16
 * Time: 07:41
 */
  // msgID 	userID 	msgContent 	msgDate
  require "./dbConnect.php";
  require "./var.php";
  session_start();
  $db = new dataBase(HOST, DB, USER, PASSWORD);
  date_default_timezone_set("Iran");
  var_dump($db->write("message", ["msgID" => "null", "userID" => $_SESSION["userID"], "msgContent" => $_POST["msgContent"], "msgDate" => date("Y-m-d h:i:s")]));
?>
