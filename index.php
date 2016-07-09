<?php
/**
 * User: raha
 * Date: 05/07/16
 * Time: 03:12
 */
  session_start();
  if (!isset($_SESSION["name"])){
    header("location: login.php");
    exit();
  }
  require "func/dbConnect.php";
  require "func/var.php";
  $db = new dataBase(HOST, DB, USER, PASSWORD);
  $profile = $db->read("user", "userID, name, imgLink", ["name" => ["value" => $_SESSION["name"], "op" => "="]], "AND", "userID", "50");
?>
<!doctype HTML>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/main.css">
    <script src="script/jquery-1.11.1.js"></script>
    <script src="script/main.js"></script>
  </head>
  <body>
    <header id="mainHeader">
      <section id="profile">
        <img id="userProfileImg" src="<?php echo $profile[0]["imgLink"]; ?>" alt="">
        <span>
          <?php echo $profile[0]["name"]; ?>
        </span>
      </section>
      <span id="log"></span>
    </header>
    <article id="message">
    </article>
    <footer id="mainFooter">
      <input id="msgTxt"  type="text"   name="" placeholder="تایپ کنید ...">
      <input id="sendBtn" type="button" value="ارسال">
    </footer>
  </body>
</html>
