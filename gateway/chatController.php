<?php
    require_once '../../codeAlongAppDBConfig.php';

    // Gets all the registered user except the logged in user
    if(isset($_POST['getUserChatFriends'])){
        $userId = $_POST['id'];

        $res = $db->query("SELECT `username`, `id`, `fName`, `lName` FROM `users` WHERE `id` != '".$userId."'");
        $parentArray = array();
        $numRows = $res->num_rows;
        if($numRows > 0){ 
            $json = array();
            while($users = $res->fetch_assoc()){
                $json[] = $users;
            }
            $resForChats = $db->query("SELECT DISTINCT username, userIdFrom, userIdTo, message, chats.created_at, chats.id AS chatId, users.id AS userId FROM chats, users WHERE users.id != '".$userId."' AND (chats.userIdFrom = '".$userId."'  OR chats.userIdTo = '".$userId."')");
            $numRowForChats = $resForChats->num_rows;
            if($numRows > 0){ 
                $jsonChats = array();
                while($resChats = $resForChats->fetch_assoc()){
                    $jsonChats[] = $resChats;
                }
            }
            
            header('Content-Type: application/json');
            array_push($parentArray, $json, $jsonChats);
            echo json_encode($parentArray);
        }
        else {
            echo 'No user is yet registered! Please invite your friends to chat with them!';
        }
    }
    if(isset($_POST['getChatDetails'])){
        $userId = $_POST['id'];
        $userFromId = $_POST['userFromId'];
        $res = $db->query("SELECT DISTINCT * FROM chats WHERE userIdTo = '".$userId."' AND userIdFrom = '".$userFromId."' OR userIdFrom = '".$userId."' AND userIdTo = '".$userFromId."' ORDER BY created_at ASC");
        $numRows = $res->num_rows;
        if($numRows > 0){
            $json = array();
            while($chats = $res->fetch_assoc()){
                $json[] = $chats;
            }
            header('Content-Type: application/json');
            echo json_encode($json);
        }
        else {
            echo 'No Chat yet! Chat with friends to see their recent or previous message!';
        }
    }
    if(isset($_POST['messageSent'])){
        $userId = $_POST['id'];
        $userTo = $_POST['userTo'];
        $message = $_POST['message'];

        $res = $db->query("INSERT INTO chats (userIdFrom, userIdTo, `message`, created_at) VALUES ($userId, $userTo, '$message', NOW() )");
        if($res){
            $last_id = mysqli_insert_id($db);
            $resSelect = $db->query("SELECT `message`, created_at FROM chats WHERE id = '".$last_id."'");
            $numRows = $resSelect->num_rows;
            if($numRows > 0){
                $json = array();
                while($chats = $resSelect->fetch_assoc()){
                    $json[] = $chats;
                }
                header('Content-Type: application/json');
                echo json_encode($json);
            }
            else {
                echo 'No Chat yet! Chat with friends to see their recent or previous message!';
            }
        } else {
            echo 2;
        }
    }
?>