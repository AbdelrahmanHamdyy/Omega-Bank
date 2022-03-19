<?php
    include 'config/db_connect.php';
    $EM = 0;
    session_start();
    $_SESSION['deleted'] = 0;
    if (isset($_POST['delete'])) {
        if (!empty($_POST['id']))
        {
        $id_to_delete = mysqli_real_escape_string($conn, $_POST['id']);
        $sql = "DELETE FROM customers WHERE id = $id_to_delete";

        if (mysqli_query($conn, $sql)) {
            // success
            $_SESSION['deleted'] = 1;
            header('Location: home.php');
        }
        else {
            echo 'Query Error: ' . mysqli_error($conn);
        }
        }
        else {
            $EM = 1;
        }
    }

    $sql = "SELECT id, name, balance FROM customers";
    $result = mysqli_query($conn, $sql);
    $all = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<html>
  <head>
    <title>Delete</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
    <style>
      .del-customer {
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
      .del-customer:hover {
        background: rgb(76, 75, 219);
        transform: scale(1.1);
      }
    </style>
  </head>
 <?php include 'template/header.php'?>
      <?php if($EM) {?>
        <script>swal("Error", "Please Select a Customer ID!", "warning");</script>
        <?php $EM = 0;?>
      <?php }?>
    <div class="container" style="margin-top: 50px;">
      <div class="row m-b-none">
        <h3 class="center-align grey-text darken-4">Delete A Customer</h3>
        <form  method="POST" style="margin-top: -10px;">
        <div class="container">
            <div class="input-field">
                <select name="id">
                    <option value="" selected disabled>Select</option>
                    <?php foreach($all as $dropdown):?>
                        <?php if ($id != $dropdown['id']) {?>
                        <option value="<?php echo $dropdown['id'];?>"><?php echo $dropdown['id']. " - " .$dropdown['name']?></option>
                    <?php } endforeach; ?>
                </select>
            </div>
        </div>
          <input style="margin-top: 10px;" type="submit" name="delete" value="DELETE" class="del-customer">
        </form>
      </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
    <?php include 'template/footer.php'?>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sel = document.querySelectorAll('select');
        M.FormSelect.init(sel);
    })
</script>