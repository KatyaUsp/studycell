<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
?>
<?php include_once "header.php"; ?>
<body>
  <section class="wrapper-video">
    <section class="video-call-area">
      <header>
        <?php 
          $sql1 = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
            if(mysqli_num_rows($sql1) > 0){
              $row1 = mysqli_fetch_assoc($sql1);
            }

          $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{
            header("location: users.php");
          }

        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <div class="details">
          <div class="user-info">
            <span><?php echo $row1['name']; ?> (You)</span>
            <span> - </span>
            <span><?php echo $row['name']; ?></span>
          </div>
          <div class="call-timer">
            <span id="callDuration">00:00</span>
          </div>
        </div>
      </header>
      <div class="video-container">
        <video id="localVideo" autoplay muted></video>
        <video id="remoteVideo" autoplay></video>
      </div>
    </section>
  </section>

  <script src="javascript/video_call.js"></script>

</body>
</html>
