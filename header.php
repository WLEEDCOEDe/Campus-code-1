<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة الدورات التعليمية | Campus Code</title>
    <meta name="description" content="منصة Campus Code التعليمية - اكتشف أفضل الدورات التعليمية في البرمجة والتقنية">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script>
        // Apply saved theme BEFORE render to avoid flash
        (function() {
            var saved = localStorage.getItem('campus-theme');
            if (saved) {
                document.documentElement.setAttribute('data-theme', saved);
            }
        })();
    </script>
</head>
<body>

    <nav class="navbar">
        <div class="navbar-brand">
            <h2><i class="fas fa-graduation-cap"></i> Campus Code</h2>
        </div>
        <div class="navbar-links">
            <a href="display_courses.php"><i class="fas fa-house"></i> الرئيسية</a>
            <a href="add_course.php"><i class="fas fa-plus"></i> إضافة دورة</a>
            <form action="search.php" method="GET" class="navbar-search">
                <input type="text" name="query" placeholder="ابحث عن دورة...">
                <button type="submit"><i class="fas fa-magnifying-glass"></i></button>
            </form>
            <button id="theme-toggle-btn" class="theme-toggle" title="تبديل الوضع" aria-label="تبديل المظهر">
                <i class="fas fa-sun icon-sun"></i>
                <i class="fas fa-moon icon-moon"></i>
            </button>
            <a href="logout.php" class="nav-link-logout"><i class="fas fa-right-from-bracket"></i> خروج</a>
        </div>
    </nav>

    <div class="container">