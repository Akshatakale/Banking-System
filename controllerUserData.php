<?php
session_start();
require "connection.php";
$email = "";
$name = "";
$errors = array();

//if user signup button
if (isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
    if ($password !== $cpassword) {
        $errors['password'] = "Confirm password not matched!";
    }
    $email_check = "SELECT * FROM usertable WHERE email = '$email'";
    $res = mysqli_query($con, $email_check);
    if (mysqli_num_rows($res) > 0) {
        $errors['email'] = "Email that you have entered is already exist!";
    }
    if (count($errors) === 0) {
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $code = rand(999999, 111111);
        $status = "notverified";
        $insert_data = "INSERT INTO usertable (name, email, password, code, status)
                        values('$name', '$email', '$encpass', '$code', '$status')";
        $data_check = mysqli_query($con, $insert_data);
        if ($data_check) {
            $subject = "Email Verification Code";
            $message = "Your verification code is $code";
            $sender = "From: demobank61@gmail.com";
            if (mail($email, $subject, $message, $sender)) {
                $info = "We've sent a verification code to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: user-otp.php');
                exit();
            } else {
                $errors['otp-error'] = "Failed while sending code!";
            }
        } else {
            $errors['db-error'] = "Failed while inserting data into database!";
        }
    }
}
//if user click verification code submit button
if (isset($_POST['check'])) {
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
    $check_code = "SELECT * FROM usertable WHERE code = $otp_code";
    $code_res = mysqli_query($con, $check_code);
    if (mysqli_num_rows($code_res) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res);
        $fetch_code = $fetch_data['code'];
        $email = $fetch_data['email'];
        $code = 0;
        $status = 'verified';
        $update_otp = "UPDATE usertable SET code = $code, status = '$status' WHERE code = $fetch_code";
        $update_res = mysqli_query($con, $update_otp);
        if ($update_res) {
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            header('location: home.php');
            exit();
        } else {
            $errors['otp-error'] = "Failed while updating code!";
        }
    } else {
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}

//if user click login button
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $check_email = "SELECT * FROM usertable WHERE email = '$email'";
    $res = mysqli_query($con, $check_email);
    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        $fetch_pass = $fetch['password'];
        if (password_verify($password, $fetch_pass)) {
            $_SESSION['email'] = $email;
            $status = $fetch['status'];
            if ($status == 'verified') {
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: home.php');
            } else {
                $info = "It's look like you haven't still verify your email - $email";
                $_SESSION['info'] = $info;
                header('location: user-otp.php');
            }
        } else {
            $errors['email'] = "Incorrect email or password!";
        }
    } else {
        $errors['email'] = "It's look like you're not yet a member! Click on the bottom link to signup.";
    }
}

//if user click continue button in forgot password form
if (isset($_POST['check-email'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $check_email = "SELECT * FROM usertable WHERE email='$email'";
    $run_sql = mysqli_query($con, $check_email);
    if (mysqli_num_rows($run_sql) > 0) {
        $code = rand(999999, 111111);
        $insert_code = "UPDATE usertable SET code = $code WHERE email = '$email'";
        $run_query =  mysqli_query($con, $insert_code);
        if ($run_query) {
            $subject = "Password Reset Code";
            $message = "Your password reset code is $code";
            $sender = "From: demobank61@gmail.com";
            if (mail($email, $subject, $message, $sender)) {
                $info = "We've sent a passwrod reset otp to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                header('location: reset-code.php');
                exit();
            } else {
                $errors['otp-error'] = "Failed while sending code!";
            }
        } else {
            $errors['db-error'] = "Something went wrong!";
        }
    } else {
        $errors['email'] = "This email address does not exist!";
    }
}

//if user click check reset otp button
if (isset($_POST['check-reset-otp'])) {
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
    $check_code = "SELECT * FROM usertable WHERE code = $otp_code";
    $code_res = mysqli_query($con, $check_code);
    if (mysqli_num_rows($code_res) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $info = "Please create a new password that you don't use on any other site.";
        $_SESSION['info'] = $info;
        header('location: new-password.php');
        exit();
    } else {
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}

//if user click change password button
if (isset($_POST['change-password'])) {
    $_SESSION['info'] = "";
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
    if ($password !== $cpassword) {
        $errors['password'] = "Confirm password not matched!";
    } else {
        $code = 0;
        $email = $_SESSION['email']; //getting this email using session
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $update_pass = "UPDATE usertable SET code = $code, password = '$encpass' WHERE email = '$email'";
        $run_query = mysqli_query($con, $update_pass);
        if ($run_query) {
            $info = "Your password changed. Now you can login with your new password.";
            $_SESSION['info'] = $info;
            header('Location: password-changed.php');
        } else {
            $errors['db-error'] = "Failed to change your password!";
        }
    }
}

//if login now button click
if (isset($_POST['login-now'])) {
    header('Location: login-user.php');
}


//if user uses submit button for new account

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $bal =  1000;
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobno = mysqli_real_escape_string($con, $_POST['mobno']);
    $add = mysqli_real_escape_string($con, $_POST['add']);
    $gen = mysqli_real_escape_string($con, $_POST['gender']);
    $acc_type = mysqli_real_escape_string($con, $_POST['acc_type']);
    $branch = mysqli_real_escape_string($con, $_POST['branch']);
    //$acc_no = mysqli_real_escape_string($con, $_POST['acc_no']);
    // $IFSC = uniqid('DEMO);
    $IFSC = 'DEMO' . rand(9999, 1111);


    $insert_data = "INSERT INTO accounts (name, balance, email, mobile_no, address, gender, acc_type, branch, IFSC)
                        values('$name',$bal,'$email', '$mobno', '$add', '$gen', '$acc_type', '$branch','$IFSC')";
    $data_check = mysqli_query($con, $insert_data);
    if ($data_check) {
        echo "<script>alert('Your account has been created Successfully..!!')</script>";
    } else {
        echo "<script>alert('Something went wrong... Please try again...')</script>";
    }
}




// if  user transfers money
if (isset($_POST['transfer'])) {

    $from = mysqli_real_escape_string($con, $_POST['sender']);
    $to = mysqli_real_escape_string($con, $_POST['receiver']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);

    $query = "SELECT balance FROM accounts WHERE acc_no ='$from'";
    $sql = mysqli_query($con, $query);
    $sender_bal = mysqli_fetch_array($sql);

    $query = "SELECT balance FROM accounts WHERE acc_no ='$to'";
    $sql1 = mysqli_query($con, $query);
    $receiver_bal = mysqli_fetch_array($sql1);

    if (($amount) < 0) {
        echo '<script type="text/javascript">';
        echo ' alert("Oops! Negative values cannot be transferred")';
        echo '</script>';
    } else if ($amount > $sender_bal['balance']) {

        echo '<script type="text/javascript">';
        echo ' alert("Bad Luck! Insufficient Balance")';
        echo '</script>';
    } else if ($amount == 0) {

        echo "<script type='text/javascript'>";
        echo "alert('Oops! Zero value cannot be transferred')";
        echo "</script>";
    } else {


        $sender_bal = $sender_bal['balance'] - $amount;
        $query = "UPDATE accounts set balance =$sender_bal WHERE acc_no ='$from'";
        $sql1 = mysqli_query($con, $query);

        $receiver_bal = $receiver_bal['balance'] + $amount;
        $query = "UPDATE accounts set balance =$receiver_bal WHERE acc_no ='$to'";
        $sql1 = mysqli_query($con, $query);

        $insert_data = "INSERT INTO transaction (sender_acc_no, receiver_acc_no, amount, sender_balance, receiver_balance)
                      values('$from', '$to', '$amount', '$sender_bal', '$receiver_bal')";
        $data_check = mysqli_query($con, $insert_data);
        if ($data_check) {
            echo "<script>alert('Your transaction has been done Successfully..!!')</script>";
        } else {
            echo "<script>alert('Something went wrong... Please try again...')</script>";
        }
    }
}


// if user tries to update details;

if (isset($_POST['update'])) {
    $acc_no = mysqli_real_escape_string($con, $_POST['acc_no']);
    $entity_type = mysqli_real_escape_string($con, $_POST['entity_type']);
    $entity = mysqli_real_escape_string($con, $_POST['entity']);

    if ($entity_type == 'mob_no') {
        $query = "UPDATE  accounts SET mobile_no =$entity WHERE acc_no ='$acc_no'";
        $sql1 = mysqli_query($con, $query);
        if ($sql1) {
            echo "<script>alert('Mobile no. updated Successfully..!!')</script>";
        } else {
            echo "<script>alert('Something went wrong... Please try again...')</script>";
        }
    }
    elseif($entity_type == 'address'){
        $query = "UPDATE  accounts SET address = '$entity' WHERE acc_no ='$acc_no'";
        $sql1 = mysqli_query($con, $query);
        if ($sql1) {
            echo "<script>alert('Address Updated Successfully..!!')</script>";
        } else {
            echo "<script>alert('Something went wrong... Please try again...')</script>";
        }
    }
    
}
