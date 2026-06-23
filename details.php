<?php 
include 'db.php';

$id = (int) $_GET['id'];

// ✅ REVIEW INSERT CODE (YAHI MAIN FIX HAI)
if(isset($_POST['review_submit'])){
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;

    mysqli_query($conn, "INSERT INTO reviews (product_id, name, comment, rating) 
    VALUES ('$id', '$name', '$comment', '$rating')");

    header("Location: details.php?id=$id");
}

// 🎨 Painting data
$art = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM paintings WHERE id=$id"));
?>
<div style="max-width: 950px; margin: 50px auto; display: flex; gap: 40px; background: #fff; padding: 40px; border-radius: 30px; box-shadow: 0 25px 50px rgba(0,0,0,0.1); font-family: sans-serif;">
    
    <div style="flex: 1.2;">
        <img src="images/<?php echo $art['image']; ?>" style="width: 100%; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.15);">
    </div>
    
    <div style="flex: 1;">
        <h1 style="color:#2c3e50; margin-top:0;">✨ <?php echo $art['title']; ?></h1>
        <p style="color:#7f8c8d;">Original Masterpiece | Certified Art</p>
        <hr>
        <form action="bill.php" method="POST" style="background: #f8f9fa; padding: 25px; border-radius: 20px; border: 1px solid #eee;">
    
    <input type="hidden" name="painting_id" value="<?php echo $id; ?>">
    <input type="hidden" name="p_title" value="<?php echo $art['title']; ?>">
    
    <label><b>📧 Email Address:</b></label><br>
    <input type="email" name="email" required placeholder="Enter your email" style="width:90%;padding:10px;margin:10px 0;border:1px solid #ddd;border-radius:8px;"><br>

    <label><b>💰 Final Amount:</b></label><br>
<input type="number" name="price" value="<?php echo $art['price']; ?>" readonly
style="width:90%; padding:12px; margin:10px 0; border:2px solid #ddd; border-radius:10px; font-size:1.1rem; font-weight:bold;"><br>
    <label><b>💳 Payment Mode:</b></label><br>
    <select name="method" style="width:96%; padding:12px; margin:10px 0; border:2px solid #ddd; border-radius:10px; background:white;">
        <option value="UPI / PhonePe">📲 UPI (Google Pay / PhonePe)</option>
        <option value="Debit Card">💳 Debit / Credit Card</option>
        <option value="Cash on Delivery">💵 Cash on Delivery</option>
    </select><br><br>

    <label><b>👤 Full Name:</b></label><br>
    <input type="text" name="name" required placeholder="Enter your full name" style="width:90%;padding:10px;margin:10px 0;border:1px solid #ddd;border-radius:8px;"><br>

    <label><b>📞 Phone Number:</b></label><br>
    <input type="text" name="phone" required placeholder="Enter your mobile number" style="width:90%;padding:10px;margin:10px 0;border:1px solid #ddd;border-radius:8px;"><br>

    <label><b>🏠 Address:</b></label><br>
    <textarea name="address" required placeholder="Enter your full address" style="width:90%;padding:10px;margin:10px 0;border:1px solid #ddd;border-radius:8px;"></textarea><br>
    
    <button type="submit" style="width:100%; padding:18px; background: #27ae60; color:white; border:none; border-radius:12px; cursor:pointer; font-weight:bold; font-size:1rem; transition:0.3s;">✅ PROCEED TO BILL</button>
</form>

        <h3 style="margin-top:30px;">💬 User Reviews</h3>
        <form method="POST" style="margin-top:15px;">
    <input type="text" name="name" placeholder="Your Name" required 
    style="width:100%; padding:10px; margin-bottom:10px; border-radius:8px; border:1px solid #ccc;">

    <textarea name="comment" placeholder="Write your review..." required 
    style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;"></textarea>
    <select name="rating" required 
    style="width:100%; padding:10px; margin-top:10px; border-radius:8px; border:1px solid #ccc;">
    <option value="">⭐ Rate</option>
    <option value="1">⭐ 1</option>
    <option value="2">⭐⭐ 2</option>
    <option value="3">⭐⭐⭐ 3</option>
    <option value="4">⭐⭐⭐⭐ 4</option>
    <option value="5">⭐⭐⭐⭐⭐ 5</option>
    </select>

    <button type="submit" name="review_submit" 
    style="margin-top:10px; padding:10px 20px; background:#3498db; color:white; border:none; border-radius:8px;">
        ⭐ Submit Review
    </button>
</form>
        <div style="max-height: 180px; overflow-y: auto; background:#fff; padding:10px; border:1px solid #eee; border-radius:10px;">
            <?php
            $revs = mysqli_query($conn, "SELECT * FROM reviews WHERE product_id=$id ORDER BY id DESC");
            while($r = mysqli_fetch_assoc($revs)) {
                echo "<p style='border-bottom: 1px solid #f0f0f0; padding:5px;'><b>⭐ {$r['name']}:</b> {$r['comment']}</p>";
            }
            ?>
        </div>
    </div>
</div>