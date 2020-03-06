<?php
header("Access-Control-Allow-Origin: *");      
session_start();
    include 'db.inc.php';


    $out = array('error' => false);

    $uid = $_POST['userName'];;
    $pwd = $_POST['password'];


    if($uid==''){
        $out['error'] = true;
        $out['message'] = "Username is required";
    }
    else if($pwd==''){
        $out['error'] = true;
        $out['message'] = "Password is required";
    // }
    // Error handlers
    // Check if inputs are empty
    // if (empty($uid) || empty($pwd)) {
        // header("Location: ../index.php?login=empty");
        // exit();
    } else {
        $sql = "SELECT * FROM users WHERE user_uid='$uid' OR user_email='$uid'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck < 1) {
            // header("Location: ../index.php?login=notuid");
            // exit();
            $out['error'] = true;
		    $out['message'] = "Login Failed. User not Found";
        } else {
            
            if ($row = mysqli_fetch_assoc($result)) {
                // De-hasing the password 
                $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
                if ($hashedPwdCheck == false) {
                    // header("Location: ../index.php?login=errorpass");
                    // $message = "failed!";
                    // echo "<script type='text/javascript'>alert('$message');</script>";
                    $out['error'] = true;
		            $out['message'] = "Login Failed!";
                } else if ($hashedPwdCheck == true) {
                    $_SESSION['u_id'] = $row['user_id'];
                    $_SESSION['u_first'] = $row['user_first'];
                    $_SESSION['u_last'] = $row['user_last'];
                    $_SESSION['u_email'] = $row['user_email'];
                    $_SESSION['u_uid'] = $row['user_uid'];
                    // header("Location: ../index.php?login=success");
                    // $message = "success!";
                    // echo "<script type='text/javascript'>alert('$message');</script>";
                    $out['message'] = "Login Successful";
                }
            }
        }
    }
    header("Content-type: application/json");
    echo json_encode($out);
    die();

?>