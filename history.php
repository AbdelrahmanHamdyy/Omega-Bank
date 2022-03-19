<?php
    include 'config/db_connect.php';
    $id = $_GET['id'];
    $query = "SELECT * FROM transfers WHERE id_from = $id ORDER BY time";
    $transfers_result = mysqli_query($conn, $query);
    $transfers = mysqli_fetch_all($transfers_result, MYSQLI_ASSOC);
    session_start();
?>

<head>
    <title>History</title>
</head>

<?php include 'template/header.php' ?>
<?php if($_SESSION['transfered'] == 1) {?>
        <script>
            swal("Success!", "Transaction Completed!", "success");
        </script>
    <?php $_SESSION['transfered'] = 0; ?>
    <?php } ?>
<h1 class="transfers_title" style="text-decoration: none;">Transfers for Customer #<?php echo $id;?></h1>
        <table style="border-top: 1px solid #d4cccc;">
        <?php if (array_filter($transfers)) { ?>
        <tr>
            <th>ID</th>
            <th>Case</th>
            <th>Name</th>
            <th>Amount ($)</th>
            <th>Time</th>
        </tr>
        <?php } 
        else 
            echo '<h5 style="text-align:center; margin-left:42.5%; 
            font-weight: bold; border: 1px solid grey; 
            border-radius: 10px; width: 15%; 
            padding: 10px;">EMPTY! <br> No Transfers Yet</h5>';?>
        <?php foreach($transfers as $transfer): ?>
            <?php echo "<tr><td>".$transfer["id_to"] ."</td><td>". $transfer["ToOrFrom"] 
                      ."</td><td>". $transfer["name"] ."</td><td>". $transfer["amount"] ."</td><td>". $transfer["time"] ."</td></tr>"; ?>
        <?php endforeach; ?>
    </table>
<?php include 'template/footer.php' ?>