<?php
    session_start();
    $_SESSION['added'] = 0;
    $_SESSION['deleted'] = 0;
    $_SESSION['transfered'] = 0;
?>

<head>
    <title>Home</title>
</head>
<style>
    body {
        background: rgb(255, 245, 255);
    }
    img {
        height: 600px;
        width: 600px;
        float: right;
        margin-right: 70px;
        margin-top: 10px;
        animation: floating 2.8s ease infinite;
    }
    .view {
        margin-left: 20%;
        margin-top: 50px;
        padding: 15px;
        background: rgb(123, 127, 255);
        font-family: serif;
        font-weight: bold;
        color: white;
        font-size: 20px;
        border-style: solid;
        border-color: rgb(255, 245, 255);
        border-radius: 10px;
        width: 20%;
        transition: all 0.3s ease-in-out;
      }
      .view:hover {
        background: rgb(76, 75, 219);
        transform: scale(1.1);
      }
      a:hover {
          background: white;
      }
      .headd h1 {
          margin-left: 40px;
          margin-top: 90px;
          font-family: cursive;
          font-weight: bold;
      }
      .headd h2 {
          margin-left: 25px;
          margin-top: 30px;
          font-family: 'Sansita Swashed', cursive;
      }
      .click a:hover {
          background: rgb(255, 245, 255);
      }
      @keyframes floating {
            0% { transform: translateY(-2%); }
            50% { transform: translateY(2%); }
            100% { transform: translateY(-2%); }
      }
}
</style>
<?php include 'template/header.php' ?>
<img src="img/Welcome.svg" alt="Pic">
<div class="headd">
<h1>Welcome to Omega Bank</h1>
<h2>Make your Online Banking <br> Experience Wonderful!</h2>
<div class="click">
<a href="home.php"><button class="view">View All Customers</button></a>
</div>
</div>