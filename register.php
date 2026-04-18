<?php
// 1. استدعاء مفتاح الاتصال بقاعدة البيانات
include 'connection.php';

// متغير فارغ لعرض رسائل النجاح أو الخطأ للطالب
$message = "";
$is_success = false;

// 2. التحقق: هل قام الطالب بالضغط على زر "تسجيل"؟
if (isset($_POST['submit'])) {
    
    // سحب البيانات التي كتبها الطالب في المربعات
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 3. التحقق الأمني: هل الإيميل يحتوي على (.edu.sa)؟
    if (strpos($email, '.edu.sa') == false) {
        $message = "عذراً، يُسمح بالتسجيل فقط للإيميلات الجامعية التي تنتهي بـ .edu.sa";
    } else {
        // 4. التشفير: تحويل كلمة المرور إلى رموز غير مفهومة لحمايتها
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 5. إرسال البيانات إلى قاعدة البيانات (جدول users)
        $query = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $message = "تم التسجيل بنجاح! حسابك الجامعي جاهز.";
            $is_success = true;
        } else {
            $message = "حدث خطأ، الإيميل قد يكون مسجلاً مسبقاً.";
        }
    }
}
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل طالب جديد | Campus Code</title>
    <meta name="description" content="إنشاء حساب جديد في منصة Campus Code التعليمية">
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
            <i class="fas fa-user-plus"></i>
        </div>
        <h2>إنشاء حساب طالب جديد</h2>
        <p class="auth-subtitle">سجّل بإيميلك الجامعي للوصول إلى الدورات</p>
        
        <?php if(!empty($message)) { 
            if($is_success) {
                echo "<div class='success-msg'><i class='fas fa-circle-check'></i> $message</div>";
            } else {
                echo "<div class='error-msg'><i class='fas fa-circle-exclamation'></i> $message</div>";
            }
        } ?>

        <form method="POST" action="">
            <div class="input-group">
                <input type="email" name="email" required placeholder="student@university.edu.sa" id="register-email">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="input-group">
                <input type="password" name="password" required placeholder="كلمة المرور" id="register-password">
                <i class="fas fa-lock"></i>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block btn-lg" id="register-submit">
                <i class="fas fa-user-plus"></i> تسجيل الحساب
            </button>
        </form>

        <div class="auth-footer">
            لديك حساب بالفعل؟ <a href="login.php">تسجيل الدخول</a>
        </div>
    </div>

</body>
</html>
