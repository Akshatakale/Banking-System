<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Account</title>
    <style>
        *{
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
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container">

        <form action="new_acc.php" method="POST">
            <div class="row">
                <h1 style="text-align: center;">Create New Account</h1>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="name">Name</label>
                </div>
                <div class="col-75">
                    <input type="text" id="name" name="name" placeholder=" Enter Your Full Name.." required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="email">Email Id</label>
                </div>
                <div class="col-75">
                    <input type="text" id="email" name="email" placeholder="abc@gmail.com" width="100%" required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="mobno">Mobile No.</label>
                </div>
                <div class="col-75">
                    <input type="text" id="mobno" name="mobno" placeholder="+91**********" required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="add">Address</label>
                </div>
                <div class="col-75">
                    <input type="text" id="add" name="add" placeholder=" Enetr Your Address" required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="gender">Gender</label>
                </div>
                <div class="col-75">
                    <select id="gender" name="gender" required>
                        <option value="select">Select</option>
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="acc_type">Account Type</label>
                </div>
                <div class="col-75">
                    <select id="acc_type" name="acc_type" required>
                        <option value="select">Select</option>
                        <option value="Savings">Savings</option>
                        <option value="Current">Current</option>
                        <option value="RD">RD</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="branch">Branch</label>
                </div>
                <div class="col-75">
                    <select id="branch" name="branch" required>
                        <option value="select">Select</option>
                        <option value="Pune">Pune</option>
                        <option value="Mumbai">Mumbai</option>

                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-75">
                    <button type="submit" id="btn" name="submit">Submit</button>
                    <button type="reset" id="btn">Cancel</button>
                </div>
            </div>
            <!-- <div class="row">
                <input type="reset" value="reset">
            </div> -->
        </form>
    </div>
     <!-- <footer> -->
     <?php include 'footer.php';   ?>
    <!-- </footer> -->




</body>

</html>