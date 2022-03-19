<?php
    include 'config/db_connect.php';
    $transfers = array();
    session_start();
    $_SESSION['transfered'] = 0;
    if (isset($_GET['id']))
    {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        $sql = 'SELECT id FROM customers ORDER BY id';
        $query = "SELECT * FROM transfers WHERE id_from = $id ORDER BY time";

        $result = mysqli_query($conn, $sql);
        $transfers_result = mysqli_query($conn, $query);

        $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $transfers = mysqli_fetch_all($transfers_result, MYSQLI_ASSOC);

        $sql = "SELECT * FROM customers WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        $current = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $sql = "SELECT id, name, balance FROM customers";
        $result = mysqli_query($conn, $sql);
        $all = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_free_result($result);
        mysqli_free_result($transfers_result);
    
        if (isset($_POST['submit']) && !empty($_POST['customerID']) && !empty($_POST['amount']))
        {
            $id_to = $_POST['customerID'];
            $amount = $_POST['amount'];

            $sql = "SELECT name FROM customers WHERE id = $id_to";
            $result = mysqli_query($conn, $sql);
            $name = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $Name = $name[0]['name'];

            $sql = "INSERT INTO transfers(id_from, id_to, ToOrFrom, name, amount) VALUES('$id', '$id_to', 'To', '$Name', '$amount')";
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE customers SET balance = balance - $amount WHERE id = $id";
            $result = mysqli_query($conn, $sql);

            $sql = "SELECT name FROM customers WHERE id = $id";
            $result = mysqli_query($conn, $sql);
            $name = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $Name = $name[0]['name'];

            $sql = "INSERT INTO transfers (id_from, id_to, ToOrFrom, name, amount) VALUES('$id_to', '$id', 'From', '$Name', '$amount')";
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE customers SET balance = balance + $amount WHERE id = $id_to";
            $result = mysqli_query($conn, $sql);
            $_SESSION['transfered'] = 1;
            header("Location: history.php?id=$id");
        }
    }

    mysqli_close($conn);

?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, options);
  });

  // Or with jQuery

  $(document).ready(function(){
    $('select').formSelect();
  });
</script>
<head>
    <title>Transfers</title>
</head>
<style>
    .view {
        margin-right: 20%;
        margin-top: 150px;
        padding: 15px;
        background: rgb(123, 127, 255);
        font-family: serif;
        font-weight: bold;
        color: white;
        font-size: 20px;
        border-style: solid;
        border-color: white;
        border-radius: 10px;
        width: 20%;
        transition: all 0.3s ease-in-out;
        float: right;
      }
      .view:hover {
        background: rgb(76, 75, 219);
        transform: scale(1.1);
      }
      a:hover {
          background: white;
      }
</style>
<?php include 'template/header.php' ?>
        <h1 class="transfers_title" style="text-decoration: none;">Customer</h1>
        <table style="border-top: 1px solid #d4cccc;">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Balance ($)</th>
        </tr>
        <?php foreach($current as $c): ?>
            <?php echo "<tr><td>".$c["id"] ."</td><td>". $c["name"] 
                      ."</td><td>". $c["email"] ."</td><td>". $c["balance"] ."</td><tr>"; ?>
        <?php endforeach; ?>
        </table>
        <a href="history.php?id=<?php echo $id; ?>"><button class="view">View All Transfers</button></a>
        <form class="center" style="border: 1px solid #d4cccc; margin-top: 40px; margin-left: 20%;" action="transfers.php?id=<?php echo$_GET['id']?>" method="POST">
        
        <!--<input class="input-field" name="customerID" type="number">-->
        <div class="container">
        <label class="center grey-text" style="font-size: 20px; color: rgb(99, 77, 77);">Transfer Money</label>
            <div class="input-field">
                <select name="customerID">
                    <option value="" selected disabled>Select a Customer</option>
                    <?php foreach($all as $dropdown):?>
                        <?php if ($id != $dropdown['id']) {?>
                        <option value="<?php echo $dropdown['id'];?>"><?php echo $dropdown['id']. " - " .$dropdown['name']. " - " .$dropdown['balance']?></option>
                    <?php } endforeach; ?>
                </select>
            </div>
        </div>
        <div style="margin-top: 30px;">
        <label class="center grey-text" style="font-size: 20px; color: rgb(99, 77, 77);" for="">Enter the amount in ($)</label>
        <input class="input-field" name="amount" type="number">
        </div>
        <input style="font-family: serif; font-weight: bold; background: #2ca0ff; margin-top: 20px;" type="submit" name="submit" onclick="success();" value="Confirm" class="btn brand z-depth-0">
    </form>
    <!--<div class="input-field col s12">
    <label>Materialize Select</label>
    <select>
      <option value="" disabled selected>Choose your option</option>
      <option value="1">Option 1</option>
      <option value="2">Option 2</option>
      <option value="3">Option 3</option>
    </select>
    </div>-->
<?php include 'template/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sel = document.querySelectorAll('select');
        M.FormSelect.init(sel);
    })
</script>

<script>
    function success() {
        /*swal({
            title: "Success!",
            text: "Transaction Completed",
            icon: "success",
            closeOnClickOutside: false,
        });
        alert("Success! Transaction Completed"); */
    }
</script>