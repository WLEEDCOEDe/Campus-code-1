<?php
// 1. نستدعي ملف الاتصال بقاعدة البيانات، ونستدعي الهيدر (الجزء العلوي للموقع)
include 'connection.php';
include 'header.php';

// 2. نتأكد إن الرابط فيه رقم الدورة (id) عشان نعرف أي دورة نعرض
if (isset($_GET['id'])) {
    $course_id = $_GET['id'];
    
    // 3. نجلب بيانات هذي الدورة فقط من جدول الدورات
    $query = "SELECT * FROM courses WHERE id = '$course_id'";
    $result = mysqli_query($conn, $query);

    // إذا لقينا الدورة في قاعدة البيانات
    if (mysqli_num_rows($result) > 0) {
        $course = mysqli_fetch_assoc($result);
        
        // ==========================================
        // بداية كود منطق الخصم (Coupon Logic)
        // ==========================================
        
        // حددنا السعر الأساسي قبل الخصم
        $original_price = $course['price']; 
        // السعر اللي بنعرضه للطالب (في البداية بيكون نفس الأساسي)
        $display_price = $original_price;
        // متغير فاضي عشان نحط فيه رسالة للطالب (صح أو خطأ)
        $coupon_message = "";

        // إذا ضغط الطالب على زر "تطبيق" كود الخصم
        if (isset($_POST['apply_coupon'])) {
            // نأخذ الكود اللي كتبه الطالب في المربع ونحميه من الاختراق
            $entered_code = mysqli_real_escape_string($conn, $_POST['coupon_code']);
            
            // نبحث عن هذا الكود في جدول الخصومات (coupons)
            $check_query = mysqli_query($conn, "SELECT * FROM coupons WHERE code = '$entered_code'");
            
            // إذا الكود موجود فعلاً في القاعدة
            if (mysqli_num_rows($check_query) > 0) {
                // نجلب بيانات الكود (عشان نعرف كم نسبة الخصم)
                $coupon_data = mysqli_fetch_assoc($check_query);
                $percent = $coupon_data['discount_percent']; // مثلاً 20
                
                // معادلة حساب الخصم: نضرب السعر في النسبة ونقسم على 100
                $discount_amount = $original_price * ($percent / 100);
                
                // ننقص قيمة الخصم من السعر الأساسي عشان نطلع السعر الجديد
                $display_price = $original_price - $discount_amount;
                
                // نجهز رسالة النجاح
                $coupon_message = "<p class='coupon-success'><i class='fas fa-circle-check'></i> تم تطبيق خصم $percent% بنجاح!</p>";
            } else {
                // إذا الكود غلط أو غير موجود نعطيه رسالة خطأ
                $coupon_message = "<p class='coupon-error'><i class='fas fa-circle-xmark'></i> كود الخصم غير صحيح</p>";
            }
        }
        // ==========================================
        // نهاية كود منطق الخصم
        // ==========================================

        // نعرض الصورة، وإذا مافيه صورة نعرض الصورة الافتراضية
        $img = !empty($course['image']) ? $course['image'] : 'default.jpg';
        ?>
        
        <div class="course-detail-card fade-in-up">
            
            <h1 class="course-detail-title"><i class="fas fa-graduation-cap"></i> <?php echo $course['title']; ?></h1>
            
            <div class="course-detail-layout">
                
                <div class="course-detail-image">
                    <img src="uploads/<?php echo $img; ?>" alt="<?php echo $course['title']; ?>">
                </div>
                
                <div class="course-detail-info">
                    
                    <p><strong><i class="fas fa-align-right"></i> تفاصيل الدورة:</strong><br> <?php echo $course['description']; ?></p>
                    
                    <div class="price-section">
                        
                        <p class="price-display"><i class="fas fa-coins"></i> السعر المطلوب: <b><?php echo $display_price; ?> ريال</b></p>
                        
                        <form method="POST" class="coupon-form">
                            <input type="text" name="coupon_code" placeholder="أدخل كود الخصم" id="coupon-input">
                            <button type="submit" name="apply_coupon" id="apply-coupon-btn"><i class="fas fa-tag"></i> تطبيق</button>
                        </form>
                        
                        <?php echo $coupon_message; ?>
                    </div>

                    <form method="POST" action="checkout.php" style="margin-top: 24px;">
                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                        <input type="hidden" name="final_price" value="<?php echo $display_price; ?>">
                        <input type="hidden" name="original_price" value="<?php echo $original_price; ?>">
                        <input type="hidden" name="coupon_used" value="<?php echo isset($_POST['coupon_code']) ? htmlspecialchars($_POST['coupon_code']) : ''; ?>">
                        <button type="submit" class="btn btn-primary btn-block btn-lg" id="enroll-btn"><i class="fas fa-cart-shopping"></i> سجل الآن</button>
                    </form>
                    
                    <div class="action-buttons">
                        <a href="edit_course.php?id=<?php echo $course['id']; ?>" class="btn btn-warning" id="edit-course-btn"><i class="fas fa-pen-to-square"></i> تعديل</a>
                        <a href="delete_course.php?id=<?php echo $course['id']; ?>" onclick="return confirm('هل أنت متأكد من الحذف؟');" class="btn btn-danger" id="delete-course-btn"><i class="fas fa-trash"></i> حذف</a>
                    </div>
                </div>
            </div>
            
            <div class="back-section">
                <a href="display_courses.php" class="back-link"><i class="fas fa-arrow-right"></i> العودة لقائمة الدورات</a>
            </div>
        </div>

        <?php
    }
}
// في النهاية نستدعي الفوتر (الجزء السفلي للموقع)
include 'footer.php';
?>