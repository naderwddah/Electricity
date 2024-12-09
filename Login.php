
<?php
session_start();
include "DB_connection.php";

// تفعيل عرض الأخطاء أثناء التطوير
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// متغيرات لرسائل الخطأ والنجاح
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    // استعلام قاعدة البيانات
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $user);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if (password_verify($pass, $row['password'])) {
        $_SESSION['user'] = $user;
        header("Location: desplayUsers.php"); // توجيه إلى صفحة رئيسية
        exit;
      } else {
        $error = "كلمة المرور غير صحيحة!";
      }
    } else {
      $error = "اسم المستخدم غير موجود!";
    }
  } else {
    $error = "يرجى ملء جميع الحقول!";
  }
}
?>
<!-- ******************************************************* -->
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="./assets/css/style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<body>
    <section class="container">
        <div class="login-container">
            <div class="circle circle-one"></div>
            <div class="form-container">
                <img src="./assets/img/illustration.png" alt="illustration" class="illustration" />
                <h1 class="opacity">LOGIN</h1>
                <form  method="POST" action="login.php" >
                  <?php if (!empty($error)): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
      <div class="alert alert-success" role="alert">
        <?php echo $success; ?>
      </div>
    <?php endif; ?>
                  
                    <input type="text" placeholder="USERNAME"  name="username" id="username" required>
                    <input type="password"  class="form-control" name="password" id="password" required>
                    <button class="opacity">SUBMIT</button>
                </form>
                <div class="register-forget opacity">
                    <a href="signup.html">REGISTER</a>
                    <a href="">FORGOT PASSWORD</a>
                </div>
            </div>
            <div class="circle circle-two"></div>
        </div>
        <div class="theme-btn-container"></div>
    </section>
</body>
<!-- partial -->
  <script  src="./script.js"></script>

</body>
</html>
