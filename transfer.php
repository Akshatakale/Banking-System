<?php
include 'config.php';

if(isset($_POST['submit']))
{
    $from = $_GET['id'];
    $to = $_POST['to'];
    $amount = $_POST['amount'];

    $sql = "SELECT * from users where id=$from";
    $query = mysqli_query($conn,$sql);
    $sql1 = mysqli_fetch_array($query); 

    $sql = "SELECT * from users where id=$to";
    $query = mysqli_query($conn,$sql);
    $sql2 = mysqli_fetch_array($query);



    
    if (($amount)<0)
   {
        echo '<script type="text/javascript">';
        echo ' alert("Oops! Negative values cannot be transferred")';
        echo '</script>';
    }


  
    
    else if($amount > $sql1['balance']) 
    {
        
        echo '<script type="text/javascript">';
        echo ' alert("Bad Luck! Insufficient Balance")'; 
        echo '</script>';
    }
    


   
    else if($amount == 0){

         echo "<script type='text/javascript'>";
         echo "alert('Oops! Zero value cannot be transferred')";
         echo "</script>";
     }


    else {
        
                // deducting amount from sender's account
                $newbalance = $sql1['balance'] - $amount;
                $sql = "UPDATE users set balance=$newbalance where id=$from";
                mysqli_query($conn,$sql);
             

                // adding amount to reciever's account
                $newbalance = $sql2['balance'] + $amount;
                $sql = "UPDATE users set balance=$newbalance where id=$to";
                mysqli_query($conn,$sql);
                
                $sender = $sql1['name'];
                $receiver = $sql2['name'];
                $sql = "INSERT INTO transaction(`sender`, `receiver`, `balance`) VALUES ('$sender','$receiver','$amount')";
                $query=mysqli_query($conn,$sql);

                if($query){
                     echo "<script> alert('Transaction Successful');
                                     window.location='transactionhistory.php';
                           </script>";
                    
                }

                $newbalance= 0;
                $amount =0;
        }
    
    
}
?>
































<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        /* h2 {
            margin-top: 50px;
            padding-top: 50px;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 60px;
            text-align: center;
            color: white;
        }

        .transfer {
            margin-left: 500px;
            margin-top: 70px;
            padding: 50px;
            /* padding-left: 100px; */
        /* height: 550px;
            width: 550px;
            border: 2px solid white;
            color: white;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .transfer img {
            height: 200px;
            padding-left: 120px;
        }

        .transfer label {
            margin-top: 10px;
            padding-top: 0px;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 30px;
        }

        .transfer input {
            width: 450px;
        }

        .transfer button {
            margin-top: 50px;
            margin-left: 0px;
            width: 150px;
        } */
    </style>
</head>

<body>
    <div class="container">
        <div class="navbar">
            <img src="Banklogo.jpg" class="logo">
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="user.php">User Details</a></li>
                    <li><a href="transfer.html">Transfer Money</a></li>
                    <li><a href="">History</a></li>
                </ul>
            </nav>
        </div>
        <h2>Transfer Money</h2>
        <form action="transfer.php" method="post">
            <div class="transfer">
                <img src="Transfer.png">
                <?php

                include "config.php";
                $sql =  "select * from userdetails.user";
                $records = mysqli_query($con, $sql) or die(mysqli_error($con));

                // echo $sql;

                ?>
                <label for="select-user">Select user to transfer Money</label>
                <select class="form-select" aria-label="Default select example">
                    <option selected><?php echo "Select user to transfer money"; ?></option>
                    <?php while ($data = mysqli_fetch_assoc($records)) { ?>
                        <option><?php echo $data['Name'], '(', $data['Balance'], ')'; ?></option>


                    <?php
                    }
                    ?>
                </select>

                <?php mysqli_close($con) ?>
                <label for="amt">Enter Amount</label>
                <br>
                <input type="number" id="userinput" name="amt">
                
               
                <button type="submit" class="btn btn-primary">Transfer</button>


            </div>
        </form>
        <?php
                $input = $_POST["amt"];
                echo $input;
                ?>
       

    </div>

    <?php




    ?>




    <!-- Footer -->
    <footer class="page-footer">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-1">© 2021 Copyright
            <h5>Project by Akshata Kale</h5>
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->

</body>



</html>