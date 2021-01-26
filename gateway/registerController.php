<?php
    if( isset($_POST['submitReg']) ){
        $error = 0;

        //require a connection to DB
        require '../../codeAlongAppDBConfig.php';
        
        if(isset($_POST['fName'])  && $_POST['fName'] != ""){
            $fName = $_POST['fName'];
        } else {
            $error = 1;
        }

        if(isset($_POST['lName'])  && $_POST['lName'] != ""){
            $lName = $_POST['lName'];
        } else {
            $error = 1;
        }

        if(isset($_POST['email'])  && $_POST['email'] != ""){
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                exit('Invalid email address'); // Use your own error handling ;)
            }
            
            $select = mysqli_query($db, "SELECT `email` FROM `users` WHERE `email` = '".$_POST['email']."'") or exit(mysqli_error($db));
            if(mysqli_num_rows($select)) {
                exit('This email is already being used');
            }
            $email = $_POST['email'];
        } else {
            $error = 1;
        }

        if(isset($_POST['username']) && $_POST['username'] != ""){

            $select = mysqli_query($db, "SELECT `username` FROM `users` WHERE `username` = '".$_POST['username']."'") or exit(mysqli_error($db));
            if(mysqli_num_rows($select)) {
                exit('This username is already being used');
            }
            $uName = $_POST['username'];
        } else {
            $error = 1;
        }

        if(isset($_POST['password'])  && $_POST['password'] != ""){
            $password = $_POST['password'];
            $pass = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $error = 1;
        }

        if($error == 1){
            echo 'Some Fields does not contain a value';
        } else {
            
            //Insert user data into DB
            $res = $db->query('INSERT INTO users (fName, lName, username, email, password, created_at) VALUES ("'.$fName.'", "'.$lName.'", "'. $uName.'","'.$email.'","'.$pass.'", NOW())');
             
            // if (mysqli_query($db, $res)) {
            //     echo "New record created successfully";
            // } else {
            //     echo "Error: " . $res . "<br>" . mysqli_error($db);
            // }
            if($res){
                echo 1;
            } else {
                echo 2;
            }
            
            
        }
    } else {//illegal access
        //redirect to home page (index.php)
        $url = '../index.php';
        header('location:'.$url);
    }
?>