<?php
// 1. استدعاء الاتصال والهيدر
include 'connection.php';
include 'header.php';

$message = "";
$is_success = false;

// 2. جلب بيانات الدورة الحالية لعرضها في النموذج
if (isset($_GET['id'])) {
    $course_id = $_GET['id'];
    $fetch_query = mysqli_query($conn, "SELECT * FROM courses WHERE id = '$course_id'");
    $course_data = mysqli_fetch_assoc($fetch_query);
}

// 3. معالجة البيانات بعد الضغط على زر "تحديث"
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $track_id = $_POST['track_id'];
    
    // معالجة الصورة (إذا اختار المستخدم صورة جديدة)
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image_name);
        // تحديث البيانات مع الصورة الجديدة
        $query = "UPDATE courses SET title='$title', price='$price', description='$description', track_id='$track_id', image='$image_name' WHERE id='$course_id'";
    } else {
        // تحديث البيانات بدون تغيير الصورة القديمة
        $query = "UPDATE courses SET title='$title', price='$price', description='$description', track_id='$track_id' WHERE id='$course_id'";
    }

    if (mysqli_query($conn, $query)) {
        $message = "تم تحديث بيانات الدورة بنجاح!";
        $is_success = true;
        // تحديث البيانات المعروضة في الصفحة
        $fetch_query = mysqli_query($conn, "SELECT * FROM courses WHERE id = '$course_id'");
        $course_data = mysqli_fetch_assoc($fetch_query);
    } else {
        $message = "حدث خطأ أثناء التحديث";
    }
}
?>

<div class="form-card fade-in-up">
    <h2><i class="fas fa-pen-to-square"></i> تعديل بيانات الدورة</h2>
    
    <?php if(!empty($message)) {
        if($is_success) {
            echo "<div class='success-msg'><i class='fas fa-circle-check'></i> $message</div>";
        } else {
            echo "<div class='error-msg'><i class='fas fa-circle-exclamation'></i> $message</div>";
        }
    } ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="edit-title"><i class="fas fa-heading"></i> عنوان الدورة</label>
            <input type="text" name="title" value="<?php echo $course_data['title']; ?>" required id="edit-title">
        </div>
        
        <div class="form-group">
            <label for="edit-price"><i class="fas fa-coins"></i> سعر الدورة</label>
            <input type="text" name="price" value="<?php echo $course_data['price']; ?>" required id="edit-price">
        </div>
        
        <div class="form-group">
            <label for="edit-desc"><i class="fas fa-align-right"></i> وصف الدورة</label>
            <textarea name="description" required rows="4" id="edit-desc"><?php echo $course_data['description']; ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="edit-track"><i class="fas fa-route"></i> المسار الحالي</label>
            <select name="track_id" id="edit-track">
                <option value="1" <?php if($course_data['track_id'] == 1) echo 'selected'; ?>>علم البيانات</option>
                <option value="2" <?php if($course_data['track_id'] == 2) echo 'selected'; ?>>حوسبة سحابية</option>
                <option value="3" <?php if($course_data['track_id'] == 3) echo 'selected'; ?>>الشبكات</option>
            </select>
        </div>

        <div class="form-group">
            <label for="edit-image"><i class="fas fa-image"></i> تغيير الصورة (اختياري)</label>
            <input type="file" name="image" id="edit-image">
        </div>
        
        <button type="submit" name="update" class="btn btn-warning btn-block btn-lg" id="update-course-btn"><i class="fas fa-floppy-disk"></i> حفظ التعديلات</button>
    </form>
    
    <div class="back-section">
        <a href="course_details.php?id=<?php echo $course_id; ?>" class="back-link"><i class="fas fa-arrow-right"></i> إلغاء والعودة</a>
    </div>
</div>

<?php include 'footer.php'; ?>