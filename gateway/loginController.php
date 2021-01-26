<?php
    if( isset($_POST['submitted']) ){//legal access

        $uName = $_POST['uName'];
        $pass = $_POST['password'];

        if(!$uName && !$pass){
            exit('Empty Username/Password');
        } else {
            require '../../codeAlongAppDBConfig.php';

            $uNameRes = $db->query('SELECT id FROM users WHERE username = "'.$uName.'"');
            $uNameNum = $uNameRes->num_rows;
            if($uNameNum > 0){ 
                $uNameRow = $uNameRes->fetch_assoc(); 
                $uNameRowId = $uNameRow['id'];
                $passRes = $db->query('SELECT password FROM users WHERE  id = "'.$uNameRowId.'"');
                $passResNum = $passRes->num_rows;
                if($passResNum > 0){ 
                    $passResRow = $passRes->fetch_assoc(); 
                    $passResRow = $passResRow['password']; 
                    $passwordVerify = password_verify($pass, $passResRow);
    
                    if($passwordVerify === true){
                        $res = $db->query('SELECT id, fName, lName, email, username FROM users WHERE  id = "'.$uNameRowId.'"');
                        $num = $res->num_rows;
    
                        if($num > 0){
                            $row = $res->fetch_assoc();
    
                            //start session
                            session_start();
                            //set session
                            $_SESSION['id'] = $row['id'];
                            $_SESSION['fName'] = $row['fName'];
                            $_SESSION['lName'] = $row['lName'];
                            $_SESSION['email'] = $row['email'];
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['loggedIn'] = true;
                            
                            
                            
                            //send to dashboard
                            echo 1;
                        }
                    }
                    else {
                        echo 'Incorrect Password!';
                    }
                }  
            } else { echo 'Username Does not exist'; }  
        } 
    } else {//illegal access
        //redirect to home page (index.php)
        $url = '../index.php';
        header('location:'.$url);
    }
?>