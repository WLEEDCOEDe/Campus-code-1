<?php
// 1. بدء الجلسة لحفظ بيانات المستخدم بعد تسجيل الدخول
session_start();

// 2. استدعاء ملف الاتصال بقاعدة البيانات
include 'connection.php';

$error_message = "";

// 3. التحقق مما إذا كان المستخدم قد ضغط على زر الدخول
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // 4. البحث عن البريد الإلكتروني في قاعدة البيانات
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // 5. فك التشفير ومطابقة كلمة المرور
        if (password_verify($password, $user['password'])) {
            // نجاح تسجيل الدخول: حفظ بيانات المستخدم في الجلسة
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            
            // 6. توجيه المستخدم لصفحة عرض الدورات (شغل المجموعة الثالثة)
            header("Location: display_courses.php");
            exit();
        } else {
            $error_message = "كلمة المرور غير صحيحة";
        }
    } else {
        $error_message = "لا يوجد حساب مسجل بهذا البريد الإلكتروني";
    }
}
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | Campus Code</title>
    <meta name="description" content="تسجيل الدخول إلى منصة Campus Code التعليمية">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script>
        (function() {
            var saved = localStorage.getItem('campus-theme');
            if (saved) document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>
</head>
<body class="auth-page">

    <div class="auth-card">
        <div class="auth-icon">
            <i class="fas fa-right-to-bracket"></i>
        </div>
        <h2>تسجيل الدخول</h2>
        <p class="auth-subtitle">أدخل بياناتك للوصول إلى منصتك التعليمية</p>
        
        <?php if(!empty($error_message)) echo "<div class='error-msg'><i class='fas fa-circle-exclamation'></i> $error_message</div>"; ?>
        
        <form method="POST" action="">
            <div class="input-group">
                <input type="email" name="email" placeholder="البريد الإلكتروني الجامعي" required id="login-email">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="كلمة المرور" required id="login-password">
                <i class="fas fa-lock"></i>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg" id="login-submit">
                <i class="fas fa-right-to-bracket"></i> دخول
            </button>
        </form>

        <div class="auth-footer">
            ليس لديك حساب؟ <a href="register.php">إنشاء حساب جديد</a>
        </div>
    </div>

</body>
</html>