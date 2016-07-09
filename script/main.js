/**
 * Created by raha on 09/07/16.
 */
"use strict";
$(document).ready(function () {
    init();
});
function init() {
    var body = document.getElementsByTagName("body")[0];
    body.style.height = window.innerHeight + "px";
    window.onresize = function() {
        body.style.height = window.innerHeight + "px";
    };
    addMsg();
    var cheakMsg = setInterval(addMsg, 3000);
    writeFocus();
    $("#sendBtn").click(function () {
        if ($('#msgTxt').val() != ""){
            insertMsg();
        } else {
            writeFocus();
        }
    });
    $('#msgTxt').keydown(function (e) {
        if (e.which == 13){
            $("#sendBtn").click();
        }
    });

    function addMsg(){
        var date = makeDate();
        var message = document.getElementById("message");
        var lastScrollTopMax = message.scrollTopMax;
        if(cheakMsg != "cleared"){
            clearInterval(cheakMsg);
        }
        $.ajax({
            url : 'func/addMsg.php',
            type : 'POST',
            data : 'date=' + date,
            statusCode : {
                404 : function(){
                    $("#log").text("مشکلی در ارتباط رخ داده است!!!")
                }
            },
            success : function(data){
                $("#message").append(data);
                if (message.scrollTop == lastScrollTopMax){
                    message.scroll(message, message.scrollTopMax);
                }
            }
        });
        function makeDate(){
            if (document.getElementsByClassName("sendTime")[0] != undefined){
                return document.getElementsByClassName("sendTime")[document.getElementsByClassName("sendTime").length - 1].textContent.trim();
            } else {
                return "";
            }
        }
        if(cheakMsg != "cleared"){
            cheakMsg = setInterval(addMsg, 3000);
        }
    }

    function insertMsg() {
        clearInterval(cheakMsg);
        cheakMsg = "cleared";
        $.ajax({
            url : 'func/sendMsg.php',
            type : 'POST',
            data : 'msgContent=' + $('#msgTxt').val(),
            statusCode : {
                404 : function(){
                    alert("مشکلی در ارتباط رخ داده است");
                }
            },
            success : function(data){
                addMsg();
                $('#msgTxt').val("");
            }
        });
        cheakMsg = setInterval(addMsg, 3000);
    }
    
    function writeFocus() {
        $("#msgTxt").focus();
    }
    
    String.prototype.replaceAll = function(search, replacement) {
        var target = this;
        return target.split(search).join(replacement);
    };


}
