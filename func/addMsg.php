<?php
/**
 * Created by PhpStorm.
 * User: raha
 * Date: 07/07/16
 * Time: 02:40
 */
  require "./dbConnect.php";
  require "./var.php";
  session_start();
  $db = new dataBase(HOST, DB, USER, PASSWORD);
  if ($_POST["date"] != ""){
    $messages = $db->read("message", "*", ["msgDate" => ["value" => $_POST["date"], "op" => ">"]], "msgDate", "");
  } else {
    $messages = $db->read("message", "*", [], "msgDate", 40);
  }
  if(!empty($messages)){
    foreach ($messages as $key => $value){
      if ($value["userID"] == $_SESSION["userID"]){
        echo "
                <section class=\"msg\">
                  <section class=\"myMsg\">
                    <article class=\"myMsgBox\">
                      <p class=\"msgContent\">
                          <pre>
{$value["msgContent"]}
                          </pre>
                      </p>
                        <span class=\"sendTime\">
                          {$value["msgDate"]}
                        </span>
                      <input class=\"option\" type=\"button\" value=\"\">
                    </article>
                  </section>
                </section>
              ";
      }else{
        echo $value["userID"];
        $senderProfile = $db->read("user", "name, imgLink", ["userID" => ["value" => $value["userID"], "op" => "="]]);
        echo "
                <section class=\"msg\">
                  <section class=\"otherMsg\">
                    <img class=\"profile\" src=\"{$senderProfile[0]["imgLink"]}\" alt=\"\">
                    <article class=\"otherMsgBox\">
                      <h1 class=\"senderName\">{$senderProfile[0]["name"]}</h1>
                      <p class=\"msgContent\">
                        <pre>
{$value["msgContent"]}
                        </pre>
                      </p>
                      <span class=\"sendTime\">
                        {$value["msgDate"]}
                      </span>
                      <input class=\"reply\" type=\"button\" value=\"\">
                    </article>
                  </section>
                </section>
              ";
      }
    }
  }

?>
