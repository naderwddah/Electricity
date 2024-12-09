
<!DOCTYPE html>
<html>
<head>
	<title>Add User form </title>

  <link rel="stylesheet" href="./assets/css/all.min.css">
  <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="./assets/css/font-awesome.css">
  <link rel="stylesheet" href="./assets/css/stylephp.css">
</head>
<body>
	<input type="checkbox" id="checkbox">
	<header class="header">
	<h2 class="u-name">Task <b>Pro</b>
		<label for="checkbox">
			<i id="navbtn" class="fa fa-bars" aria-hidden="true"></i>
		</label>
	</h2>
	<span class="notification" id="notificationBtn">
		<i class="fa fa-bell" aria-hidden="true"></i>
		<span id="notificationNum"></span>
	</span>
</header>
<div class="notification-bar" id="notificationBar">
	<ul id="notifications">
	
	</ul>
</div>
<script type="text/javascript">
	var openNotification = false;

	const notification = ()=> {
		let notificationBar = document.querySelector("#notificationBar");
		if (openNotification) {
			notificationBar.classList.remove('open-notification');
			openNotification = false;
		}else {
			notificationBar.classList.add('open-notification');
			openNotification = true;
		}
	}
	let notificationBtn = document.querySelector("#notificationBtn");
	notificationBtn.addEventListener("click", notification);
</script>
<script type="text/javascript">
	$(document).ready(function(){

       $("#notificationNum").load("app/notification-count.php");
       $("#notifications").load("app/notification.php");

   });
</script>	<div class="body">
    <?php include("nav.php"); ?>
    <section class="section-1">
        <h4 class="title">Add Users <a href="desplayUsers.php">Users</a></h4>

        <?php
        include("DB_connection.php");

        // تفعيل عرض الأخطاء أثناء التطوير
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $error = ""; // لرسائل الخطأ
        $success = ""; // لرسائل النجاح

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // التحقق من المدخلات
            if (!empty($_POST['full_name']) && !empty($_POST['user_name']) && !empty($_POST['password'])) {
                $fullName = trim($_POST['full_name']);
                $username = trim($_POST['user_name']);
                $password = $_POST['password'];

                // التحقق من وجود المستخدم مسبقًا
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
                $stmt->bindParam(':username', $username);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $error = "اسم المستخدم موجود مسبقًا!";
                } else {
                    // تشفير كلمة المرور
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // إدخال المستخدم الجديد إلى قاعدة البيانات
                    $stmt = $conn->prepare("INSERT INTO users (full_name, username, password) VALUES (:full_name, :username, :password)");
                    $stmt->bindParam(':full_name', $fullName);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $hashedPassword);

                    if ($stmt->execute()) {
                        $success = "تم إضافة المستخدم بنجاح!";
                    } else {
                        $error = "حدث خطأ أثناء إضافة المستخدم!";
                    }
                }
            } else {
                $error = "يرجى ملء جميع الحقول!";
            }
        }
        ?>

        <!-- عرض رسائل الخطأ أو النجاح -->
        <?php if (!empty($error)): ?>
            <div class="danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="success" role="alert">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <form class="form-1" method="POST" action="#">
            <div class="input-holder">
                <label>Full Name</label>
                <input type="text" name="full_name" class="input-1" placeholder="Full Name" required><br>
            </div>
            <div class="input-holder">
                <label>Username</label>
                <input type="text" name="user_name" class="input-1" placeholder="Username" required><br>
            </div>
            <div class="input-holder">
                <label>Password</label>
                <input type="password" name="password" class="input-1" placeholder="Password" required><br>
            </div>

            <button class="edit-btn" type="submit">Add</button>
        </form>
    </section>
</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(2)");
	active.classList.add("active");
</script>
<script src="./assets/js/all.min.js"></script>
<script src="./assets/js/bootstrap.bundle.min.js"></script>
<script src="./assets/js/jquery-3.6.0.js"></script>
</body>
</html>
