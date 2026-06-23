<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>🌟 Premium Art Gallery</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f4f8; margin: 0; }
        
        /* 📱 Navigation Bar */
        .navbar { background: linear-gradient(135deg, #2c3e50, #4ca1af); color: white; padding: 15px 50px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 15px rgba(0,0,0,0.2); position: sticky; top: 0; z-index: 1000; }
        
        /* 🖼️ Gallery Grid */
        .gallery { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; padding: 40px; }
        
        .card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); transition: 0.4s ease; position: relative; border: 1px solid #eee; }
        .card:hover { transform: translateY(-15px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
        
        /* 🔍 Deep Zoom Feature */
        .img-box { height: 260px; overflow: hidden; position: relative; }
        .img-box img { width: 100%; height: 100%; object-fit: cover; transition: 0.7s; cursor: zoom-in; }
        .img-box img:hover { transform: scale(1.15); }
        .img-box img:active { transform: scale(2.8); position: fixed; top: 50%; left: 50%; translate: -50% -50%; z-index: 2000; border: 8px solid #fff; box-shadow: 0 0 100px rgba(0,0,0,0.5); border-radius: 10px; }

        .card-body { padding: 20px; text-align: center; }
        .card-body h3 { margin: 10px 0; color: #333; font-size: 1.4rem; }
        .price-tag { color: #2ecc71; font-size: 1.5rem; font-weight: 800; margin: 15px 0; display: block; }
        
        /* ✨ Animated Button */
        .btn-buy { background: #e67e22; color: #fff; padding: 12px 30px; text-decoration: none; border-radius: 50px; display: inline-block; font-weight: bold; transition: 0.3s; box-shadow: 0 4px 10px rgba(230, 126, 34, 0.3); }
        .btn-buy:hover { background: #d35400; transform: scale(1.05); box-shadow: 0 6px 15px rgba(211, 84, 0, 0.4); }
    </style>
</head>
<body>
    <div class="navbar">
        <h2 style="margin:0;">💎 ART<span style="color:#f1c40f;">GEM</span> GALLERY</h2>
        <a href="admin_dashboard.php" style="color:white; text-decoration:none; font-weight:bold;">👤 MY ACCOUNT</a>
    </div>

    <div class="gallery">
        <?php
        $res = mysqli_query($conn, "SELECT * FROM paintings");
        while($row = mysqli_fetch_assoc($res)) {
            echo "<div class='card'>
                    <div class='img-box'>
                        <img src='images/{$row['image']}' title='Hold Click to Zoom 🔍'>
                    </div>
                    <div class='card-body'>
                        <h3>🎨 {$row['title']}</h3>
                        <span class='price-tag'>₹" . number_format($row['price']) . "</span>
                        <a href='details.php?id={$row['id']}' class='btn-buy'>🛒 BUY NOW</a>
                 </div>
                  </div>";
        }
        ?>
    </div>
</body>
</html>