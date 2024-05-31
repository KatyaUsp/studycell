<?php 
session_start();
include_once "php/config.php";

// Ensure the user is logged in
if(!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit;
}

$unique_id = $_SESSION['unique_id'];
$name = $password = $age = $email = $language = $interests = $info = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['update_id'])) {
        $update_id = mysqli_real_escape_string($conn, $_GET['update_id']);
        $get_user = "SELECT * FROM users WHERE unique_id = {$update_id}";
        $run_user = mysqli_query($conn, $get_user);
        
        if (mysqli_num_rows($run_user) > 0) {
            $row = mysqli_fetch_assoc($run_user);

            $name = $row['name'];
            $age = $row['age'];
            $email = $row['email'];
            $password = $row['password'];
            $language = $row['language'];
            $interests = $row['interests'];
            $info = $row['info'];
        } else {
            echo "User not found.";
            exit;
        }
    } else {
        echo "No user ID provided.";
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['update_id'])) {
        $update_id = mysqli_real_escape_string($conn, $_GET['update_id']);
        
        $name_new = mysqli_real_escape_string($conn, $_POST['name']);
        $password_new = mysqli_real_escape_string($conn, $_POST['password']);
        $age_new = mysqli_real_escape_string($conn, $_POST['age']);
        $email_new = mysqli_real_escape_string($conn, $_POST['email']);
        $language_new = mysqli_real_escape_string($conn, $_POST['language']);
        $interests_new = mysqli_real_escape_string($conn, $_POST['interests']);
        $info_new = mysqli_real_escape_string($conn, $_POST['info']);

        // Update variables for displaying after the form submission
        $name = $name_new;
        $password = $password_new;
        $age = $age_new;
        $email = $email_new;
        $language = $language_new;
        $interests = $interests_new;
        $info = $info_new;

        if (!empty($name_new) && !empty($age_new) && !empty($language_new) && !empty($password_new)) {
            if (filter_var($email_new, FILTER_VALIDATE_EMAIL)) {
                $encrypt_pass = md5($password_new);
                $update_query = mysqli_query($conn, "UPDATE users SET name = '{$name_new}', email = '{$email_new}', password = '{$encrypt_pass}', age = '{$age_new}', language = '{$language_new}', interests = '{$interests_new}', info = '{$info_new}' WHERE unique_id = '{$update_id}'");

                if ($update_query) {
                    header("Location: users.php");
                    exit;
                } else {
                    echo "Something went wrong. Please try again!";
                }
            } else {
                echo "$email_new is not a valid email!";
            }
        } else {
            echo "Check required input fields!";
        }
    } else {
        echo "No user ID provided.";
    }
} else {
    echo "Invalid request method.";
    exit;
}
?>

<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="form signup">
      <header>StudyCell</header>
      <form action="update.php?update_id=<?php echo $_GET['update_id']; ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="field input">
          <label>Name</label>
          <input type="text" name="name" placeholder="Your name" required value="<?php echo htmlspecialchars($name); ?>">
        </div>
        <div class="field input">
          <label>Email</label>
          <input type="text" name="email" placeholder="Enter your email" required value="<?php echo htmlspecialchars($email); ?>">
        </div>
        <div class="field input">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter new password" required value = "<?php echo htmlspecialchars($password); ?>">
          <i class="fas fa-eye"></i>
        </div>
        <div class="name-details">
          <div class="field input">
            <label>Age</label>
            <input type="text" name="age" placeholder="Your age" required value="<?php echo htmlspecialchars($age); ?>">
          </div>
          <div class="field input">
            <label>Language</label>
            <input type="text" name="language" placeholder="Your language" required value="<?php echo htmlspecialchars($language); ?>">
          </div>
        </div>
        <div class="field input">
          <label>Learning interests</label>
          <input type="text" name="interests" placeholder="Subject to study" required value="<?php echo htmlspecialchars($interests); ?>">
        </div>
        <div class="field input">
          <label>Additional information</label>
          <input type="text" name="info" placeholder="Preferred communication methods or time" required value="<?php echo htmlspecialchars($info); ?>">
        </div>
        <div class="field button">
          <input type="submit" name="submit2" value="Update Profile">
        </div>
      </form>
    </section>
  </div>
  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/update.js"></script>
</body>
</html>
