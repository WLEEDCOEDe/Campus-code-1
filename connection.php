<?php
// هذا الملف يربط موقعنا بقاعدة البيانات
$conn = mysqli_connect(
    getenv('MYSQLHOST')     ?: 'mysql.railway.internal',
    getenv('MYSQLUSER')     ?: 'root',
    getenv('MYSQLPASSWORD') ?: 'uVkNBVnuhsmWBozSenWmEOcxzJRQdlhf',
    getenv('MYSQLDATABASE') ?: 'railway',
    getenv('MYSQLPORT')     ?: '3306'
);

if (!$conn) {
    echo "يوجد مشكلة في الاتصال بقاعدة البيانات";
}
?>
