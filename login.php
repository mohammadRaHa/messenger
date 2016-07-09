<?php
/**
 * Created by PhpStorm.
 * User: raha
 * Date: 08/07/16
 * Time: 05:17
 */
include "func/dbConnect.php";
require "func/var.php";
session_start();
if (isset($_POST["submit"])){
  $name = $_POST["username"];
  $pass = $_POST["password"];
  $db = new dataBase(HOST, DB, USER, PASSWORD);
  $verify = $db->read("user", "*", ["name" => ["value" => $name, "op" => "="], "password" => ["value" => $pass, "op" => "="]]);
  if (count($verify) > 0){
    $_SESSION["name"] = $name;
    $_SESSION["userID"] = $verify[0]["userID"];
    header("location: index.php");
    exit();
  } else {
    echo "incorect";
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Log in</title>
  <style>
    *{
      direction: rtl;
    }
    body{
      margin: 0 auto;
      width: 960px;
    }
    input{
      float: right;
      clear: both;
    }
    label{
      float: right;
      clear: both;
    }
  </style>
</head>
<body>
  <header>
    <h1>
      مسنجر اختصاصی اعضای شرکت مبتکران نوین پرنیان
    </h1>
  </header>
  <article>
    <h1>
      توجه داشته باشید که فقط اعضای داخلی شرکت میتوانند به این مسنجر وارد شوند.
    </h1>
    <form action="login.php" method="post">
      <label for="userName">
        نام کاربری :
      </label>
      <input id="userName" name="username" type="text">
      <label for="passWord">
        کلمه عبور :
      </label>
      <input id="passWord" name="password" type="text">
      <input type="submit" name="submit" value="ورود!">
    </form>
  </article>
</body>
</html>

