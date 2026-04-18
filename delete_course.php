<?php
// 1. استدعاء ملف الاتصال بقاعدة البيانات
include 'connection.php';

// 2. التحقق من وجود رقم الدورة (id) المراد حذفها
if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // (لمسة احترافية للدرجات): جلب اسم الصورة لحذفها من مجلد uploads لكي لا تستهلك مساحة
    $img_query = "SELECT image FROM courses WHERE id = '$course_id'";
    $img_result = mysqli_query($conn, $img_query);
    if ($img_row = mysqli_fetch_assoc($img_result)) {
        $image_path = "uploads/" . $img_row['image'];
        // حذف الصورة إذا كانت موجودة وليست الصورة الافتراضية
        if (file_exists($image_path) && $img_row['image'] != 'default.jpg' && !empty($img_row['image'])) {
            unlink($image_path); 
        }
    }

    // 3. أمر الحذف من قاعدة البيانات
    $query = "DELETE FROM courses WHERE id = '$course_id'";
    $result = mysqli_query($conn, $query);

    // 4. بعد الحذف بنجاح، يتم طرد المستخدم وإعادته لصفحة البطاقات
    if ($result) {
        header("Location: display_courses.php");
        exit();
    } else {
        include 'header.php';
        echo "<div class='delete-error'><h3><i class='fas fa-circle-exclamation'></i> حدث خطأ أثناء الحذف</h3></div>";
        include 'footer.php';
    }
} else {
    // إذا دخل شخص الصفحة بالغلط بدون تحديد دورة، نعيده للصفحة الرئيسية
    header("Location: display_courses.php");
    exit();
}
?>