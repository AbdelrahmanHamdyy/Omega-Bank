<?php 
    
    include 'config/db_connect.php';

    session_start();

    // Write query to get all customers
    $sql = 'SELECT id, name, email, balance FROM customers ORDER BY id';

    // Make query & get result
    $result = mysqli_query($conn, $sql);

    // Fetch the resulting rows as an array
    $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Free result from memory
    mysqli_free_result($result);

    // Close Connection
    mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
</head>
<style>
    .view:hover {
        background: none;
        color: rgb(254, 32, 252);
        text-decoration: underline;
        transition: 0s;
    }
</style>
    <?php include 'template/header.php'?>
    <?php if($_SESSION['added'] == 1) {?>
        <script>
            swal("Success!", "Customer Added", "success");
        </script>
    <?php $_SESSION['added'] = 0; ?>
    <?php } ?>
    <?php if($_SESSION['deleted'] == 1) {?>
        <script>
            swal("Success!", "Customer Deleted", "success");
        </script>
    <?php $_SESSION['deleted'] = 0; ?>
    <?php } ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Balance ($)</th>
            <th>History</th>
        </tr>
        <?php foreach($customers as $customer): ?>
            <?php echo "<tr><td>".$customer["id"] ."</td><td>". $customer["name"] 
                      ."</td><td>". $customer["email"] ."</td><td>". $customer["balance"] ."</td>"; ?>
            <td><a class="view" href="transfers.php?id=<?php echo $customer['id']; ?>">View</a></td></tr>
        <?php endforeach; ?>
    </table>

    <?php include 'template/footer.php'?>

</html>