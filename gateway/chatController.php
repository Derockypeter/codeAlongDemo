<?php
    require_once '../../codeAlongAppDBConfig.php';

    // Gets all the registered user except the logged in user
    if(isset($_POST['getUserChatFriends'])){
        $userId = $_POST['id'];

        $res = $db->query("SELECT `username`, `id`, `fName`, `lName` FROM `users` WHERE `id` != '".$userId."'");
        $parentArray = array();
        $numRows = $res->num_rows;

        if($numRows > 0){ 
            $userData = [];
            while($users = $res->fetch_assoc()){
                $tmp = [];
                $userId = $users['id'];
                $tmp['id'] = $userId;
                $tmp['username'] = $users['username'];
                $resForChats = $db->query("SELECT chats.* FROM chats WHERE chats.userIdFrom = ".$userId." OR chats.userIdTo = ".$userId);
                $chatNumRows = $resForChats->num_rows;
                $tmp['chats'] = [];
                if($chatNumRows > 0) {
                    while($userChats = $resForChats->fetch_assoc()){
                        $tmp['chats'][]= $userChats;
                        // array_push($tmp['chats'], $userChats);
                    }
                }
                $userData[] = $tmp;
                // array_push($userData, $tmp);
            }
            
            echo json_encode($userData);
        } else {
            echo 404;
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