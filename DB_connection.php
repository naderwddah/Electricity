<?php
$host = "localhost";
$dbname = "nader"; // استبدلها باسم قاعدة بياناتك
$username = "root"; // اسم المستخدم الافتراضي
$password = ""; // كلمة المرور الافتراضية (عادةً فارغة)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>
