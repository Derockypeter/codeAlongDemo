<?php
    session_start();

    if(!isset($_SESSION['loggedIn'])){
        //redirect to home page (index.php)
        $url = '../index.php';
        header('location:'.$url);
    } else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$_SESSION['username']?></title>
        <link href="../public/css/codeAlongDemo.css" rel="stylesheet">
        <style>
            * {
                font-family: 'Roboto', sans-serif;
                margin: 0px;
                padding: 0px;
                box-sizing: border-box;
            }

            body {
                background: #dbdbdb;
            }
        </style>
    </head>
    <body>
        <!-- <div class="container">
            <div id="usersBox">
                User Content
            </div>
            <div id="chatBox">
                Chats
            </div>
        </div> -->
        <div class="pink-background"></div>
		<div class="container">
            <div id="usersBox">
                <div class="profile">
                    <img src="../public/image/user-alt-512.webp">
                    
                    <div class="uName">
                        <p>
                            <?=$_SESSION['username']?>
                            <form>
                                <a href="#" class="logout">Logout</a>
                            </form>
                            
                        </p>
                    </div>
                    
                </div>
                <div class="contact-list"></div>
            </div>
            <div id="chatBoxFresh">
                <div class="freshLoad">
                    <p>Welcome to Lete'Chat</p>
                    <p>Lete'chat <?=$_SESSION['username']?></p>
                </div>
               
            </div>
            <div id="chatBox" class="hide">
                <div class="chat-head">
                    <img alt="profilepicture">
                    <div class="chat-name">
                        <h1 class="font-name"></h1>
                    </div>
                </div>
                <div class="chatContainer">
                    <div class="chat"></div>
                </div>
                <div class="messageContainer">
                    <div class="message">
                        <input type="text" class="input-message" placeholder="Input Message" name="message">
                    </div>
                </div>
            </div>
		</div>

    </body>

    <script src="../public/js/jquery-3.5.1.min.js"></script>
    <script>
        const userId = <?=$_SESSION['id']?>;

        localStorage.setItem('lastLoggedInTime', new Date());
        let lastLoggedInTime = localStorage.getItem('lastLoggedInTime');
        
        $.ajax({
            type: 'POST',
            url: '../gateway/chatController.php',
            dataType: 'json',
            data: {'id': userId, 'getUserChatFriends': true},
            success: function(data){
                if(data) {
                    data[0].forEach(element => {

                        // data[1].forEach(elem => {
                        //     // Split timestamp into [ Y, M, D, h, m, s ]
                        //     var mySqlTime = (elem.created_at).split(/[- :]/);

                        //     // Apply each element to the Date function
                        //     var convMySQLTime = new Date(Date.UTC(mySqlTime[0], mySqlTime[1]-1, mySqlTime[2], mySqlTime[3], mySqlTime[4], mySqlTime[5]));
                        //     console.log(convMySQLTime)
                        //     if(convMySQLTime > lastLoggedInTime && elem.userIdFrom == element.id){
                        //         console.log(elem.username, element.username, elem.message)
                        //     }
                        //     else {
                        //         console.log('nothing')
                        //     }
                        // })
                        var html = $("<div class='contact' id='" + element.id + "' onclick=getChatWithUser('"+element.id+"','"+element.username+"')><img src='../public/image/user-alt-512.webp'><div class='contact-preview'><div class='contact-text'><h1 class='font-name'>" + element.username + "</h1></div></div>");
                        $(".contact-list").prepend(html);
                        
                    });
                }
            }
        });
        function getChatWithUser(id, name){
            let chat = $('.chat')
            $('#chatBoxFresh').addClass('hide') // Welcome Page hide
            $('#chatBox').removeClass('hide') // Chats remove hide prop
            $('.contact').removeClass("active-contact"); // Active contact
            $('#' + id).addClass("active-contact");
            chat.empty();
            
            $.ajax({
                type: 'POST',
                url: '../gateway/chatController.php',
                dataType: 'json',
                data: {'id': userId, 'userFromId': id, 'getChatDetails': true},
                success: function(data){
                    if(data){
                        $(".chat-head img").attr("src", '../public/image/user-alt-512.webp');
                        $(".chat-name h1").text(name);
                        data.forEach(element => {
                            if(element.userIdTo == userId){
                                $(".chat").append("<div class='chat-bubble you'><div class='your-mouth'></div><div class='content'>" + element.message + "</div><div class='time'>" + element.created_at + "</div></div>");
                            }
                            else {
                                $(".chat").append("<div class='chat-bubble me'><div class='my-mouth'></div><div class='content'>" + element.message + "</div><div class='time'>" + element.created_at + "</div></div>");
                            }
                        });
                    }
                    chat[0].scrollTop = chat[0].scrollHeight;
                }
            });


            
            $(".input-message").keyup(function (ev) {
                if (ev.which == 13) {
                    let messageVal = $("input[name='message']").val()
                    if(messageVal != ''){
                        let data = {'message': messageVal, 'userTo': parseInt(id), 'id': userId, 'messageSent': true}
                        $.ajax({
                            type: 'POST',
                            url: '../gateway/chatController.php',
                            dataType: 'json',
                            data: data,
                            success: function(data){
                                if(data){
                                    console.log(data)
                                    var frm = document.getElementsByName('message')[0];
                                    frm.value = null;
                                    data.forEach(element => {
                                        $(".chat").append("<div class='chat-bubble me'><div class='my-mouth'></div><div class='content'>" + element.message + "</div><div class='time'>" + element.created_at + "</div></div>");
                                    });
                                   
                                }
                                chat[0].scrollTop = chat[0].scrollHeight;
                            }
                        });
                        
                    }
                }
            });
        };

        $('.logout').on('click', function() {
            $.ajax({
                method: 'POST',
                url: '../gateway/logoutController.php',
                success: (data) => {
                    if(data == 1){
                        window.location.replace('../index.php');
                    }
                }
            });
        });
    </script>
</html>
<?php
    }
?>