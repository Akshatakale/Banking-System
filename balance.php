<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
            height: 600px;
        }

        /* Style inputs, select elements and textareas */
        input[type=text],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            resize: vertical;
        }

        /* Style the label to display next to the inputs */
        label {
            padding: 12px 12px 12px 0;
            display: inline-block;
        }

        h1 {
            margin-top: 20px;
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

        /* Floating column for labels: 25% width */
        .col-25 {
            float: left;
            width: 25%;
            margin-top: 6px;
        }

        /* Floating column for inputs: 75% width */
        .col-75 {
            float: left;
            width: 75%;
            margin-top: 6px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 600px) {

            .col-25,
            .col-75,
            input[type=submit] {
                width: 100%;
                margin-top: 0;
            }
        }

        #btn {
            margin-top: 20px;
            margin-left: 20px;
            padding: 20px 20px 20px 20px;
            height: 55px;
            font-size: 20px;
            width: 100px;
            cursor: pointer;
            outline: none;
            color: black;
            background-color: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
            float: left;
            position: relative;
            left: 55%;

        }

        #btn:active {
            background-color: rgb(180, 243, 180);
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }
    </style>
</head>

<body>
    <?php include 'navbar.php' ?>
    <div class="container">
        <form action="balance.php" method="POST">
            <div class="row">
                <h1 style="text-align: center;">View Balance..!!</h1>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="name">Select Account To View Balance</label>
                </div>
                <div class="col-75">
                    <select id="name" name="name" required>
                        <option value="select">Select</option>
                        <?php
                        $email = $_SESSION['email'];
                        $sql1 = "SELECT name, acc_type , acc_no FROM accounts WHERE email = '$email'";
                        $res1  = mysqli_query($con, $sql1);
                        while ($row = $res1->fetch_assoc()) {
                            echo " <option value='$row[acc_no]'>$row[name] - $row[acc_type] - $row[acc_no]</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-75">
                    <button type="submit" id="btn" name="balance">View</button>
                </div>
            </div>
            <div class="row">
             <h2 style="text-align: center; margin-top:60px; font: size 80px;">
                <?php 
                if(isset($_POST['balance'])){
       
                    $acc_no = mysqli_real_escape_string($con, $_POST['name']);
                             
                    $query = "SELECT name, acc_type, balance FROM accounts WHERE acc_no = '$acc_no'";
                    $run = mysqli_query($con, $query);
                    $bal = mysqli_fetch_array($run);
                
                    if($run){
                        echo "$bal[name] your balance for $bal[acc_type] account $acc_no is RS. $bal[balance]";
                    }
                
                    else{
                        echo "<script>alert('Something went wrong... Please try again...')</script>";
                    } 
                
                
                }?></h2>
            </div>
        </form>
    </div>
    <?php include 'footer.php' ?>
</body>

</html>