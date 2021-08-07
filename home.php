<!DOCTYPE html>
<html lang="en">
<?php require_once "controllerUserData.php"; ?>
<?php
$email = $_SESSION['email'];
$password = $_SESSION['password'];
if ($email != false && $password != false) {
    $sql = "SELECT * FROM usertable WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if ($run_Sql) {
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
        if ($status == "verified") {
            if ($code != 0) {
                header('Location: reset-code.php');
            }
        } else {
            header('Location: user-otp.php');
        }
    }
} else {
    header('Location: login-user.php');
} ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial;
            font-size: 17px;
            background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('bgimg.jpg');
            background-repeat: no-repeat;
            background-size: 100% 100%;


        }

        h1 {
            margin-left: 30px;
            position: relative;
            top: 15%;
            left: 50%;
            width: 100%;
            text-align: center;
            transform: translate(-50%, -50%);
            font-size: 50px;
            font-weight: 600;
        }

        .container {
            position: relative;
            max-width: 400px;
            max-height: 266px;
            /* margin: 10px 20px 20px 20px; */
            border: 2px solid white;



        }

        .container img {
            vertical-align: middle;
        }

        .container .content {
            position: absolute;
            bottom: 0;
            background: rgb(0, 0, 0);
            /* Fallback color */
            background: rgba(0, 0, 0, 0.5);
            /* Black background with 0.5 opacity */
            color: #f1f1f1;
            width: 100%;
            padding: 20px;
        }

        .row {
            content: "";
            display: flex;
            clear: both;
            /* padding: 30px; */
            justify-content: flex-start;
            flex-direction: row;
            align-content: center;
            flex-wrap: nowrap;
            align-items: flex-end;
        }


        .column {
            float: left;
            /* width: 25%; */
            padding: 30px;
            /* height: 300px; Should be removed. Only for demonstration */
        }

        .chip {
            display: flex;
            align-items: center;
            margin-left: 95px;
            padding: 0 25px;
            height: 100px;
            width: 350px;
            font-size: 30px;
            line-height: 50px;
            border-radius: 50px;
            background-color: rgb(245, 222, 202);


        }

        .chip img {
            float: left;
            margin: 0 10px 0 -25px;
            height: 100px;
            width: 100px;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php';   ?>

    <div class="row">

        <div class="column">
            <a href='transaction.php'>
                <div class="container" style="width:400px; height: 266px;">
                    <img src="Transaction.jpg" alt="Notebook" style="width: 100%; height: 100%;">
                    <div class="content">
                        <h2>Transaction</h2>
                        <p>Transfer of Money.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="column">
            <a href="details.php">
                <div class="container" style="width:400px; height: 266px;">
                    <img src=" details.jpg" alt="Notebook" style="width:100%; height: 100%;">
                    <div class="content">
                        <h2>Details</h2>
                        <p>View Account Details.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="column" style="display: flex; flex-direction: row;  justify-content: flex-end;">
            <div class="row">
                <h1>Welcome <br> <?php echo $fetch_info['name'] ?></h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <a href='history.php'>
                <div class="container" style="width:400px; height: 266px;">
                    <img src="History.jpg" alt="Notebook" style="width:100%; height: 100%;">
                    <div class="content">
                        <h2>History</h2>
                        <p>View Transaction History.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="column">
            <a href='balance.php'>
                <div class="container" style="width:400px; height: 266px;">
                    <img src="balance.jpg" alt="Notebook" style="width:100%; height: 100%;">
                    <div class="content">
                        <h2>Balance</h2>
                        <p>View Account Balance.</p>
                    </div>
                </div>
            </a>
        </div>
        <!-- </div> -->
        <!-- <div class="row1"> -->
        <div class="column" style="display: block; flex-direction: row;  justify-content: flex-end;">
            <div class="chip">
                <a href="new_acc.php"><img src="plus.jpg" alt="Person" width="96" height="96"></a>
                New Account
            </div>
            <br>
            <div class="chip">
               <a href="update.php"><img src="user.png" alt="Person" width="96" height="96"></a>
                Update Details
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>

</html>