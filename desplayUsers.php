<?php
session_start();
include "DB_connection.php";
function get_all_users($conn)
{
  $query = "SELECT * FROM users";  // تحقق من أن اسم الجدول صحيح  
  $result = $conn->query($query);

  if ($result) {
    return $result->fetchAll(PDO::FETCH_ASSOC);  // جلب جميع المستخدمين  
  } else {
    return []; // إرجاع مصفوفة فارغة إذا كان هناك خطأ  
  }
}
// استدعاء دالة لجلب جميع المستخدمين  
$users = get_all_users($conn); // تأكد من وجود الدالة وتصحيحها  

?>
<!DOCTYPE html>
<html>

<head>
  <title>Desplay Users</title>
  <link rel="stylesheet" href="./assets/css/all.min.css" />
  <link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="./assets/css/font-awesome.css" />
  <link rel="stylesheet" href="./assets/css/stylephp.css" />

</head>

<body>
  <input type="checkbox" id="checkbox">
  <header class="header">
    <h2 class="u-name">المستخدمين  <b>المدرا </b>
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

    const notification = () => {
      let notificationBar = document.querySelector("#notificationBar");
      if (openNotification) {
        notificationBar.classList.remove('open-notification');
        openNotification = false;
      } else {
        notificationBar.classList.add('open-notification');
        openNotification = true;
      }
    }
    let notificationBtn = document.querySelector("#notificationBtn");
    notificationBtn.addEventListener("click", notification);
  </script>

  <script src="./assets/js/jquery-3.6.0.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {

      $("#notificationNum").load("app/notification-count.php");
      $("#notifications").load("app/notification.php");

    });
  </script>
  <div class="body">
  <?php  include("nav.php") ?>
    <section class="section-1">
      <h4 class="title">Manage Users <a href="add_userform.php">Add User</a></h4>

      <?php if (!empty($users)) { ?> <!-- استخدام !empty() للتأكد من وجود بيانات -->
        <table class="main-table">
          <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Username</th>

            <th>Action</th>
          </tr>
          <?php $i = 0;
          foreach ($users as $user) { ?>
            <tr>
              <td><?= ++$i ?></td>
              <td><?= htmlspecialchars($user['username']) ?></td>
              <td><?= htmlspecialchars($user['password']) ?></td>

            </tr>
          <?php } ?>
        </table>
      <?php } else { ?>
        <h3>Empty</h3>
      <?php } ?>
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