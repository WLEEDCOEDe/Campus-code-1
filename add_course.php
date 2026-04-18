<?php
// 1. استدعاء الاتصال والهيدر
include 'connection.php';
include 'header.php';

$message = "";
$is_success = false;

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $track_id = $_POST['track_id'];

    // ==========================================
    // معالجة رفع الصورة
    // ==========================================
    $image_name = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $upload_folder = 'uploads/'; // المجلد الذي أنشأناه

    // إذا لم يقم المستخدم برفع صورة، سنضع صورة افتراضية
    if (empty($image_name)) {
        $image_name = 'default.jpg';
    } else {
        // إذا رفع صورة، ننقلها من الذاكرة المؤقتة إلى مجلد uploads
        move_uploaded_file($image_tmp_name, $upload_folder . $image_name);
    }

    // إضافة اسم الصورة في استعلام قاعدة البيانات
    $query = "INSERT INTO courses (title, price, description, track_id, image) 
              VALUES ('$title', '$price', '$description', '$track_id', '$image_name')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $message = "تمت إضافة الدورة بنجاح!";
        $is_success = true;
    } else {
        $message = "حدث خطأ أثناء الإضافة";
    }
}
?>

<div class="form-card fade-in-up">
    
    <h2><i class="fas fa-plus-circle"></i> لوحة الإدارة: إضافة دورة جديدة</h2>
    
    <?php if(!empty($message)) {
        if($is_success) {
            echo "<div class='success-msg'><i class='fas fa-circle-check'></i> $message</div>";
        } else {
            echo "<div class='error-msg'><i class='fas fa-circle-exclamation'></i> $message</div>";
        }
    } ?>

    <form method="POST" action="" enctype="multipart/form-data">
        
        <div class="form-group">
            <label for="course-title"><i class="fas fa-heading"></i> عنوان الدورة</label>
            <input type="text" name="title" required id="course-title" placeholder="أدخل عنوان الدورة">
        </div>
        
        <div class="form-group">
            <label for="course-price"><i class="fas fa-coins"></i> سعر الدورة</label>
            <input type="text" name="price" required id="course-price" placeholder="أدخل السعر بالريال">
        </div>
        
        <div class="form-group">
            <label for="course-desc"><i class="fas fa-align-right"></i> وصف الدورة (نبذة بسيطة)</label>
            <textarea name="description" required rows="4" id="course-desc" placeholder="اكتب وصفاً مختصراً للدورة"></textarea>
        </div>
        
        <div class="form-group">
            <label for="course-track"><i class="fas fa-route"></i> اختر المسار</label>
            <select name="track_id" id="course-track">
                <option value="1">علم البيانات</option>
                <option value="2">حوسبة سحابية</option>
                <option value="3">الشبكات</option>
            </select>
        </div>

        <div class="form-group">
            <label for="course-image"><i class="fas fa-image"></i> صورة الدورة</label>
            <input type="file" name="image" accept="image/*" id="course-image">
        </div>
        
        <button type="submit" name="submit" class="btn btn-secondary btn-block btn-lg" id="save-course-btn"><i class="fas fa-floppy-disk"></i> حفظ الدورة</button>
    </form>
</div>

<?php 
// 2. استدعاء الفوتر
include 'footer.php'; 
?>