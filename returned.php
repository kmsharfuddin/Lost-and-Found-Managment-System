<?php
session_start();
$file = "data/reports.txt";

if(!isset($_SESSION['admin'])){
    header("Location: admin.php");
    exit();
}

$lost_data = null;
$found_data = null;
$lines = file_exists($file) ? file($file) : [];

// ইউআরএল থেকে দুটি ডাটার আইডি রিসিভ করা হচ্ছে
$lost_id = $_GET['lost_id'] ?? null;
$found_id = $_GET['found_id'] ?? null;

if($lost_id !== null && isset($lines[$lost_id])){
    $d = explode("|", trim($lines[$lost_id]));
    $lost_data = $d;
}
if($found_id !== null && isset($lines[$found_id])){
    $d = explode("|", trim($lines[$found_id]));
    $found_data = $d;
}

/* ফাইনাল রিটার্ন সাবমিশন হ্যান্ডলার */
if(isset($_POST['confirm_return'])){
    if($lost_id !== null && isset($lines[$lost_id])){
        $d = explode("|", trim($lines[$lost_id]));
        $d[10] = "Returned"; // হারানো ব্যক্তির ফাইলের স্ট্যাটাস আপডেট
        $lines[$lost_id] = implode("|", $d) . "\n";
    }
    if($found_id !== null && isset($lines[$found_id])){
        $d = explode("|", trim($lines[$found_id]));
        $d[10] = "Returned"; // পাওয়া ব্যক্তির ফাইলের স্ট্যাটাস আপডেট
        $lines[$found_id] = implode("|", $d) . "\n";
    }
    file_put_contents($file, implode("", $lines));
    echo "<script>alert('Success! Item marked as Returned.'); window.location.href='admin.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact & Return Facilitator</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 30px; background: #f4f6f9; color: #333; }
        .contact-container { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 900px; margin: 0 auto; }
        .grid { display: flex; gap: 25px; margin-top: 20px; }
        .col { flex: 1; padding: 20px; border-radius: 8px; border: 1px solid #e0e0e0; background: #fafafa; }
        .heading { text-align: center; color: #2c3e50; }
        .info-row { margin-bottom: 12px; font-size: 1.05em; }
        .info-row span { font-weight: bold; color: #555; }
        .action-area { text-align: center; margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; }
        .btn-confirm { background: #2ecc71; color: white; padding: 12px 30px; border: none; border-radius: 5px; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .btn-confirm:hover { background: #27ae60; }
        .back-link { display: inline-block; margin-top: 15px; color: #7f8c8d; text-decoration: none; }
    </style>
</head>
<body>

<div class="contact-container">
    <h2 class="heading">🤝 Matchmaker Contact & Settlement Page</h2>
    <p style="text-align:center; color:#7f8c8d;">“Contact both persons using the contact information below. After handing over the item, click the button below.”</p>

    <?php if($lost_data && $found_data): ?>
        <div class="grid">
            <div class="col" style="border-top: 5px solid #e74c3c;">
                <h3 style="color:#e74c3c; margin-top:0;">🔴 Owner Info (Who Lost)</h3>
                <div class="info-row"><span>👤 Name:</span> <?php echo $lost_data[6] ?? ''; ?></div>
                <div class="info-row"><span>📞 Phone:</span> <a href="tel:<?php echo $lost_data[7] ?? ''; ?>"><?php echo $lost_data[7] ?? ''; ?></a></div>
                <div class="info-row"><span>📧 Email:</span> <?php echo $lost_data[8] ?? ''; ?></div>
                <div class="info-row"><span>🧾 Item:</span> <?php echo $lost_data[1] ?? ''; ?></div>
                <div class="info-row"><span>📍 Lost Location:</span> <?php echo $lost_data[4] ?? ''; ?></div>
            </div>

            <div class="col" style="border-top: 5px solid #3498db;">
                <h3 style="color:#3498db; margin-top:0;">🔵 Finder Info (Who Found)</h3>
                <div class="info-row"><span>👤 Name:</span> <?php echo $found_data[6] ?? ''; ?></div>
                <div class="info-row"><span>📞 Phone:</span> <a href="tel:<?php echo $found_data[7] ?? ''; ?>"><?php echo $found_data[7] ?? ''; ?></a></div>
                <div class="info-row"><span>📧 Email:</span> <?php echo $found_data[8] ?? ''; ?></div>
                <div class="info-row"><span>🧾 Item Found:</span> <?php echo $found_data[1] ?? ''; ?></div>
                <div class="info-row"><span>📍 Found Location:</span> <?php echo $found_data[4] ?? ''; ?></div>
            </div>
        </div>

        <div class="action-area">
            <form method="POST">
                <button name="confirm_return" class="btn-confirm" onclick="return confirm('জিনিসটি কি সত্যিই আসল মালিকের নিকট হস্তান্তর করা হয়েছে?')">🔒 Confirm Handover & Mark Returned</button>
            </form>
            <a href="admin.php" class="back-link">⬅ Cancel & Go Back</a>
        </div>
    <?php else: ?>
        <p style="color:red; text-align:center;">Error: Missing report references.</p>
        <center><a href="admin.php" class="back-link">Go Back</a></center>
    <?php endif; ?>
</div>

</body>
</html>চের কন্টাক্ট ইনফো ব্যবহার করে দুজনের সাথে যোগাযোগ করুন এবং জিনিসটি হস্তান্তর শেষে নীচের বাটনে চাপ দিন।