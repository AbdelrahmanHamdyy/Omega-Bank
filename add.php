<?php 
  include 'config/db_connect.php';

  $flag = 1;
  session_start();
  $_SESSION['added'] = 0;
  $errors = array('Name' => '', 'email' => '', 'balance' => '');
  $Name = $email = $balance = "";
  if(isset($_POST['submit'])) {
      $flag = 0;
      // Check Email
      if (empty($_POST['email'])) {
          $errors['email'] = 'An Email is required <br/>';
      } 
      else {
          $email = $_POST['email'];
          if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $errors['email'] = 'Email must be valid!'.'</br>';
          }
      }

      // Check Name
      if (empty($_POST['Name'])) {
          $errors['Name'] = 'A Name is required <br/>';
      } 
      else {
          // echo htmlspecialchars($_GET['title'].'</br>');
          $Name = $_POST['Name'];
          if (!preg_match('/^[a-zA-Z\s]+$/', $Name)) {
              $errors['Name'] = 'Name must be letters and spaces only!'.'</br>';
          }
      }

      // Check Balance
      if (empty($_POST['balance'])) {
        $errors['balance'] = 'Please enter the current balance <br/>';
      }
      else {
        $balance = $_POST['balance'];
      }
  } // end of the POST check

  if (!array_filter($errors)) { // Returns false if errors is empty
      if (!$flag) {
          //echo 'Form is valid';
          $email = mysqli_real_escape_string($conn, $_POST['email']);
          $Name = mysqli_real_escape_string($conn, $_POST['Name']);
          $balance = mysqli_real_escape_string($conn, $_POST['balance']);
          
          // SQL
          $sql = "INSERT INTO customers(name, email, balance) VALUES('$Name', '$email', '$balance')";

          // Save to DB & Check
          if (mysqli_query($conn, $sql)) {
              // Success
              $_SESSION['added'] = 1;
              header('Location: home.php');
          }
          else {
              echo 'query error: '.mysqli_error($conn);
          }
      }
  }
?>
<html>
  <head>
    <title>Add</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
    <style>
      .add-customer {
        margin-left: 35%;
        padding: 15px;
        background: #2ca0ff;
        font-family: serif;
        color: white;
        font-size: 20px;
        border-style: solid;
        border-color: white;
        border-radius: 10px;
        width: 30%;
        transition: all 0.3s ease-in-out;
      }
      .add-customer:hover {
        background: rgb(76, 75, 219);
        transform: scale(1.1);
      }
    </style>
  </head>
 <?php include 'template/header.php'?>
    <div class="container" style="margin-top: 50px;">
      <div class="row m-b-none">
        <h3 class="center-align grey-text darken-4">Enter Customer Details</h3>
        <form action="add.php" method="POST">
          <div class='input-field'>
            <input type='email' name='email' id='email' value="<?php echo htmlspecialchars($email)?>" />
            <label style="font-size: 17px;">Email</label>
            <div class="red-text"><?php echo $errors['email'];?></div>
          </div>
          <div class='input-field'>
            <input type='text' name='Name' value="<?php echo htmlspecialchars($Name)?>"/>
            <label style="font-size: 17px;">Name</label>
            <div class="red-text"><?php echo $errors['Name'];?></div>
          </div>
          <div class='input-field'>
            <input type='number' name='balance' value="<?php echo htmlspecialchars($balance)?>"/>
            <label style="font-size: 17px;">Balance (in $)</label>
            <div class="red-text"><?php echo $errors['balance'];?></div>
          </div>
          <input style="margin-top: 10px;" type="submit" name="submit" value="ADD" class="add-customer">
        </form>
      </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
    <?php include 'template/footer.php'?>
</html>