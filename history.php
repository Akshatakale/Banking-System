<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction history</title>
    <style>
        * {
            margin: 0;
            padding: 0;
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

        /* Style the submit button */
        input[type=submit] {
            background-color: #04AA6D;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }

        /* Style the container */
        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
            height: 600px;
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

        table {
            margin-top: 50px;
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php' ?>
    <div class="container">
        <form action="history.php" method="POST">
            <div class="row">
                <h1 style="text-align: center;">View History..!!</h1>
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
                <table class="table table-hover table-striped table-condensed table-bordered">
                    <thead>
                        <tr>

                            <th>Sender</th>
                            <th>Receiver</th>
                            <th>Amount</th>
                            <th>Sender Balance</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if (isset($_POST['balance'])) {
                            $acc_no = mysqli_real_escape_string($con, $_POST['name']);
                            $sql = "SELECT sender_acc_no, receiver_acc_no, amount, sender_balance, datetime FROM transaction WHERE sender_acc_no = '$acc_no'";

                            $query = mysqli_query($con, $sql);
                            $res = mysqli_fetch_array($query);
                               
                            while ($rows = $query->fetch_assoc()) {                               
                                        echo "<tr>            
                                            <td> $rows[sender_acc_no]</td> 
                                            
                                            <td> $rows[receiver_acc_no]</td>
                                            
                                            <td> $rows[amount]</td>
                                            
                                            <td> $rows[sender_balance]</td>
                                           
                                            <td >$rows[datetime]</td>
                                            </tr>";
                                        }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>


    <?php include 'footer.php' ?>
</body>

</html>