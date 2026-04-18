<?php
// هذا الملف يربط موقعنا بقاعدة البيانات
$conn = mysqli_connect("localhost", "root", "", "my_project");

if (!$conn) {
    echo "يوجد مشكلة في الاتصال بقاعدة البيانات";
}
?>
