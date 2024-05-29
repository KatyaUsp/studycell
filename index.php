<?php 
  session_start();
  if(isset($_SESSION['unique_id'])){
    header("location: users.php");
  }
?>

<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="form signup">
      <header>StudyCell</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="field input">
          <label>Name</label>
           <input type="text" name="name" placeholder="Your name" required>
        </div>
        <div class="field input">
          <label>Email</label>
          <input type="text" name="email" placeholder="Enter your email" required>
          </div>
         <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter new password" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="name-details">
          <div class="field input">
            <label>Age</label>
            <input type="text" name="age" placeholder="Your age" required>
          </div>
           <div class="field input">
          <label>Language</label>
          <input type="text" name="language" placeholder="Your language" required>
          </div>
         </div>
         <div class="field input">
          <label>Learning interests</label>
          <input type="text" name="interests" placeholder="Subject to study" >
        </div>
        <div class="field input">
          <label>Additional information</label>
          <input type="text" name="info" placeholder="Preferred communication methods or time" >
        </div>

       
        <div class="field button">
          <input type="submit" name="submit" value="Create a profile">
        </div>
      </form>
      <div class="link">Already signed up? <a href="login.php">Login now</a></div>
    </section>
  </div>

  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/signup.js"></script>

</body>
</html>
