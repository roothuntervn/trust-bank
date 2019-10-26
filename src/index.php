<?php
  session_start();
  require_once("config.php");

  if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
  }

  if (isset($_GET['debug'])) {
  	highlight_file(__FILE__);
  }

  $data = get_multiusers(array("bill_gate", "mark", "drx", $_SESSION['username']));

  if (isset($_POST['submit']) && isset($_POST['fromAcc']) && isset($_POST['password']) && isset($_POST['toAcc']) && isset($_POST['money'])) {

    $auth = (md5($_POST['password']) === $data[$_POST['fromAcc']]['password']) ? 1 : 0;
    $qry_str = 'fromAcc=' . $_POST['fromAcc'] . '&toAcc=' . $_POST['toAcc'] . "&auth=" . $auth . '&money=' . $_POST['money'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_transfer);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$qry_str);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());
    curl_exec($ch);
    curl_close($ch);
    header("Location: index.php");
    die();
  }
?>

<!-- Hey hacker, let's become the most richest people in the world, you will know the secret!-->
<!-- debug mode will be your friend -->

<html>
<title>Banking</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<body>
<span class="w3-large w3-text-green"> <a href="logout.php">Logout</a></span> | <span class="w3-large w3-text-blue"><a href="reset.php">Reset database</a></span>
<?php if (isset($_SESSION['message'])) echo "<div class='w3-text-red' style='text-align:center;margin:5px;'><i>" . $_SESSION['message'] . "</i></div><hr>"; unset($_SESSION['message']); ?>
<div>
<div class="w3-card-4" style="margin:60px;display:inline-block;float:left;">
  <div class="w3-container w3-teal">
    <h3 style="text-align:center;">Transfer Money</h3>
  </div>
  <form class="w3-container" action="" method="post">
    <p>      
    <label class="w3-text-teal"><b>Your account</b></label>
    <input class="w3-input w3-grey w3-sand" name="fromAcc" type="text"></p>
    <p>      
    <label class="w3-text-teal"><b>Your password</b></label>
    <input class="w3-input w3-grey w3-sand" name="password" type="text"></p>
    <p>      
    <label class="w3-text-teal"><b>To account</b></label>
    <input class="w3-input w3-grey w3-sand" name="toAcc" type="text"></p>
    <p>      
   	<label class="w3-text-teal"><b>Money</b></label>
    <input class="w3-input w3-grey w3-sand" name="money" type="text"></p>
    <p>   
    <button class="w3-btn w3-blue-grey" name="submit" style="display:block;margin:auto;">Transfer</button></p>
    <span id="error-message"></span>
  </form>
</div>
<div style="margin:40px;display:inline-block;margin-top:50px;">
	<h2 class="w3-text-blue" style="text-align:center;">TRUST BANK</h2>
	<h4 class="w3-text-red" style="text-align:center;">We keep your money, we protect your money!</h4>
	<img src="image/background.jpg" width=410px>
</div>
<div class="w3-container" style="max-width:500px;margin:40px;display:inline-block;float:right">
  <h3 class="w3-text-teal" style="text-align:center;">Top Richest People</h3>
  <ul class="w3-ul w3-card-4">
    <li class="w3-bar">
      <img src="image/bill-gate.png" class="w3-bar-item w3-circle w3-hide-small" style="width:85px">
      <div class="w3-bar-item">
        <span class="w3-large w3-text-blue"><?php echo $data["bill_gate"]['name']; ?></span><br>
        <span class="w3-medium">CEO of Microsoft</span><br>
        <span class="w3-text-green"><?php echo $data["bill_gate"]['moneys']; ?> $</span>
        <span type="hidden" name="account" value="bill-gate"></span>
      </div>
    </li>

    <li class="w3-bar">
      <img src="image/mark.jpeg" class="w3-bar-item w3-circle w3-hide-small" style="width:85px">
      <div class="w3-bar-item">
        <span class="w3-large w3-text-blue"><?php echo $data["mark"]['name']; ?></span><br>
        <span>CEO of Facebook</span><br>
        <span class="w3-text-green"><?php echo $data["mark"]['moneys']; ?> $</span>
        <span type="hidden" name="account" value="mark"></span>
      </div>
    </li>

    <li class="w3-bar">
      <img src="image/drx.png" class="w3-bar-item w3-circle w3-hide-small" style="width:85px">
      <div class="w3-bar-item">
        <span class="w3-large w3-text-blue"><?php echo $data["drx"]['name']; ?></span><br>
        <span>CEO of RootHunter</span><br>
        <span class="w3-text-green"><?php echo $data["drx"]['moneys']; ?> $</span>
        <span type="hidden" name="account" value="drx"></span>
      </div>
    </li>

    <li class="w3-bar">
      <img src="image/hacker.png" class="w3-bar-item w3-circle w3-hide-small" style="width:85px">
      <div class="w3-bar-item">
        <span class="w3-large w3-text-blue"><?php echo $data[$_SESSION["username"]]['name']; ?></span><br>
        <span>Beginner Hacker</span><br>
        <span class="w3-text-green"><?php echo $data[$_SESSION["username"]]['moneys']; ?> $</span>
        <span type="hidden" name="account" value="doublevkay"></span>
      </div>
    </li>

  </ul>
</div>
</div>

</body>
</html>
