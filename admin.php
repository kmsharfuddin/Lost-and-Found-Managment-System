<?php
session_start();

$file = "data/reports.txt";

/* ================= ADMIN LOGIN ================= */
$admin_user = "sayedjr113488";
$admin_pass = "jonayedjr113488";

if(isset($_POST['login'])){
    if($_POST['username'] == $admin_user && $_POST['password'] == $admin_pass){
        $_SESSION['admin'] = true;
    } else {
        $error = "Wrong Login";
    }
}

if(isset($_GET['logout'])){
    session_destroy();
    header("Location: admin.php"); 
    exit();
}

/* ================= ACTION FUNCTIONS ================= */
if(isset($_SESSION['admin']) && file_exists($file)){
    $lines = file($file);
    $action_triggered = false;

    // ক. ডিলিট লজিক
    if(isset($_GET['delete']) && isset($lines[$_GET['delete']])){
        unset($lines[$_GET['delete']]);
        $action_triggered = true;
    }

    // খ. অ্যাপ্রুভ লজিক
    if(isset($_GET['approve']) && isset($lines[$_GET['approve']])){
        $d = explode("|", trim($lines[$_GET['approve']]));
        $d[10] = "Approved"; 
        $lines[$_GET['approve']] = implode("|", $d) . "\n";
        $action_triggered = true;
    }

    // গ. রিজেক্ট লজিক
    if(isset($_GET['reject']) && isset($lines[$_GET['reject']])){
        $d = explode("|", trim($lines[$_GET['reject']]));
        $d[10] = "Rejected"; 
        $lines[$_GET['reject']] = implode("|", $d) . "\n";
        $action_triggered = true;
    }

    if($action_triggered){
        file_put_contents($file, implode("", $lines));
        header("Location: admin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Smart Matching Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 25px; background: #f4f6f9; color: #333; }
        .login-box { max-width: 300px; margin: 100px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center; }
        .login-box input { width: 90%; padding: 8px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; }
        .login-box button { background: #2c3e50; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; }
        
        .logout-btn { background:#e74c3c; color:#fff; padding:6px 12px; text-decoration:none; border-radius:4px; font-weight:bold; float: right; }
        .report-box { border:1px solid #e0e0e0; padding:20px; margin:15px 0; background:#fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        
        /* Pair Block Styling */
        .pair-container { border: 2px dashed #2ecc71; padding: 20px; margin: 25px 0; background: #fdfffd; border-radius: 12px; box-shadow: 0 4px 12px rgba(46, 204, 113, 0.1); }
        .pair-header { background: #2ecc71; color: white; padding: 10px 15px; margin: -20px -20px 15px -20px; border-top-left-radius: 10px; border-top-right-radius: 10px; display: flex; justify-content: space-between; align-items: center; font-weight: bold; }
        .match-badge { background: #fff; color: #2ecc71; padding: 4px 10px; border-radius: 20px; font-size: 0.9em; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .match-details { background: #e8f8f0; border: 1px solid #c3e6cb; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 6px; font-size: 0.95em; }
        
        .flex-grid { display: flex; gap: 20px; }
        .flex-col { flex: 1; border: 1px solid #eaeaea; padding: 15px; background: #fff; border-radius: 6px; }
        
        /* Full Pair Actions Block */
        .pair-actions-block { background: #fcfcfc; border: 1px solid #ddd; padding: 15px; margin-top: 15px; border-radius: 6px; text-align: center; }
        
        /* Action Buttons Styling */
        .btn { text-decoration: none; font-weight: bold; display: inline-block; margin-top: 10px; margin-right: 5px; padding: 6px 12px; border-radius: 4px; font-size: 0.85em; transition: 0.3s; }
        .btn-approve { color: #27ae60; border: 1px solid #27ae60; }
        .btn-approve:hover { background: #27ae60; color: #fff; }
        .btn-reject { color: #e67e22; border: 1px solid #e67e22; }
        .btn-reject:hover { background: #e67e22; color: #fff; }
        .btn-delete { color: #e74c3c; border: 1px solid #e74c3c; }
        .btn-delete:hover { background: #e74c3c; color: #fff; }
        .btn-return { background: #9b59b6; color: #fff; border: 1px solid #9b59b6; font-size: 1em; padding: 8px 20px; }
        .btn-return:hover { background: #8e44ad; }
        
        @media (max-width: 768px) { .flex-grid { flex-direction: column; } }
    </style>
</head>

<body>

<?php if(!isset($_SESSION['admin'])){ ?>
    <div class="login-box">
        <h2>Admin Login</h2>
        <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button name="login">Login</button>
        </form>
    </div>
<?php exit(); } ?>

<a href="?logout=1" class="logout-btn">Logout</a>
<h2>📋 Admin Panel - Smart Report Matrix</h2>
<hr>

<?php
if(!file_exists($file) || filesize($file) == 0){
    echo "<p>No reports found in system.</p>";
    exit();
}

$lines = file($file);

$lost_reports = [];
$found_reports = [];
$all_valid_reports = []; // আপনার চাহিদা মতো সব রিপোর্ট স্টোর করার জন্য

/* ১. ফিল্টারিং এবং অল-রিপোর্ট প্রসেসিং */
foreach($lines as $index => $line){
    if(strpos($line, '|') === false || strpos($line, '<?php') !== false || strpos($line, '$_SESSION') !== false || trim($line) == "") {
        continue; 
    }

    $d = explode("|", trim($line));

    $report_data = [
        'index'       => $index,
        'type'        => trim($d[0] ?? ''),
        'title'       => trim($d[1] ?? ''),
        'category'    => trim($d[2] ?? ''),
        'time'        => trim($d[3] ?? ''),
        'location'    => trim($d[4] ?? ''),
        'description' => trim($d[5] ?? ''),
        'name'        => trim($d[6] ?? ''),
        'phone'       => trim($d[7] ?? ''),
        'email'       => trim($d[8] ?? ''),
        'image'       => trim($d[9] ?? ''),
        'status'      => trim($d[10] ?? 'Pending')
    ];

    if($report_data['type'] == "" && $report_data['title'] == "") continue;

    $all_valid_reports[] = $report_data; // সব রিপোর্ট মাস্টার লিস্টে যাচ্ছে

    $type_lower = strtolower($report_data['type']);
    if($type_lower == 'lost'){
        $lost_reports[] = $report_data;
    } elseif($type_lower == 'found') {
        $found_reports[] = $report_data;
    }
}

/* ২. MAXIMUM MATCHING ALGORITHM (জোড়া তৈরি) */
$pairs = [];
$matched_lost_indices = [];
$matched_found_indices = [];

foreach($lost_reports as $l_idx => $lost){
    $best_match_idx = -1;
    $max_percentage = 0;
    $best_reasons = "";

    foreach($found_reports as $f_idx => $found){
        if(in_array($f_idx, $matched_found_indices)) continue;

        $total_score = 0;
        $checked_fields = 0;
        $matched_fields = [];

        if(!empty($lost['title']) && !empty($found['title'])){
            $checked_fields++;
            similar_text(strtolower($lost['title']), strtolower($found['title']), $perc);
            if($perc >= 70){ $total_score += $perc; $matched_fields[] = "Item Name (".round($perc)."%)"; }
        }
        if(!empty($lost['category']) && !empty($found['category'])){
            if(strtolower($lost['category']) == strtolower($found['category'])){ $checked_fields++; $total_score += 100; $matched_fields[] = "Category (100%)"; }
        }
        if(!empty($lost['location']) && !empty($found['location'])){
            $checked_fields++;
            similar_text(strtolower($lost['location']), strtolower($found['location']), $perc);
            if($perc >= 60){ $total_score += $perc; $matched_fields[] = "Location (".round($perc)."%)"; }
        }

        if(count($matched_fields) >= 1 && $checked_fields > 0){
            $current_percentage = round($total_score / $checked_fields);
            if($current_percentage > $max_percentage && $current_percentage >= 50){
                $max_percentage = $current_percentage;
                $best_match_idx = $f_idx;
                $best_reasons = implode(", ", $matched_fields);
            }
        }
    }

    if($best_match_idx != -1){
        $pairs[] = [
            'lost' => $lost,
            'found' => $found_reports[$best_match_idx],
            'percentage' => $max_percentage,
            'reasons' => $best_reasons
        ];
        $matched_lost_indices[] = $l_idx;
        $matched_found_indices[] = $best_match_idx;
    }
}

/* === ক. ম্যাচ হওয়া জোড়াগুলো ও তাদের অ্যাকশন বাটন === */
if(!empty($pairs)){
    echo "<h3>🤝 Auto-Matched Pairs (Maximum Similarity)</h3>";
    foreach($pairs as $pair){
        echo "<div class='pair-container'>";
        echo "<div class='pair-header'>";
        echo "<span>🔄 Best Match Group</span>";
        echo "<span class='match-badge'>🔥 " . $pair['percentage'] . "% Match</span>";
        echo "</div>";
        echo "<div class='match-details'>📢 <b>Matching points:</b> " . $pair['reasons'] . "</div>";
        
        echo "<div class='flex-grid'>";
            // Lost কলাম
            echo "<div class='flex-col' style='border-left: 4px solid #e74c3c;'><b style='color:#e74c3c;'>🔴 LOST REPORT</b><br><br>";
            displayReportDetailsInline($pair['lost']);
            echo "</div>";
            
            // Found কলাম
            echo "<div class='flex-col' style='border-left: 4px solid #3498db;'><b style='color:#3498db;'>🔵 FOUND REPORT</b><br><br>";
            displayReportDetailsInline($pair['found']);
            echo "</div>";
        echo "</div>";
        
        // পুরো পেয়ার বা জোড়ার নিচের মেইন একশন (যা সরাসরি কন্টাক্ট পেজে নিয়ে যাবে)
        echo "<div class='pair-actions-block'>";
        echo "📦 <b>“Do you want to give the item back to the owner successfully”?</b><br>";
        
        // সেশন বা ইউআরএল প্যারামিটারের মাধ্যমে দুজনের আইডি পাঠানো হচ্ছে কন্টাক্ট পেজে
        echo "<a href='returned.php?lost_id=".$pair['lost']['index']."&found_id=".$pair['found']['index']."' class='btn btn-return'>🤝 Proceed to Return & Contact</a>";
        echo "</div>";
        echo "</div>";
    }
}

/* === খ. আপনার রিকোয়ারমেন্ট অনুযায়ী ফাইলে থাকা সব রিপোর্টের মাস্টার লিস্ট === */
echo "<h3>📊 Master List (All System Reports)</h3>";
if(empty($all_valid_reports)){
    echo "<p>No valid reports found.</p>";
} else {
    foreach($all_valid_reports as $report){
        $border_color = "#ccc";
        if(strtolower($report['type']) == 'lost') $border_color = "#e74c3c";
        if(strtolower($report['type']) == 'found') $border_color = "#3498db";

        echo "<div class='report-box' style='border-left: 5px solid $border_color;'>";
        echo "📌 Type: <b>".$report['type']."</b> | Status: <b>".$report['status']."</b><br><br>";
        displayReportDetailsInline($report);
        echo "</div>";
    }
}

// কমন ডিসপ্লে ফাংশন
function displayReportDetailsInline($report) {
    echo "🧾 Title: <b>".$report['title']."</b><br>";
    echo "📍 Category: ".$report['category']."<br>";
    echo "⏰ Time: ".$report['time']."<br>";
    echo "📌 Location: ".$report['location']."<br>";
    echo "📝 Description: ".$report['description']."<br>";
    echo "👤 Name: ".$report['name']."<br>";
    echo "📞 Phone: ".$report['phone']."<br>";
    echo "📧 Email: ".$report['email']."<br>";
    echo "📊 Status: <b>".$report['status']."</b><br>";
    
    // প্রতিটা আলাদা ফাইলের পাশে নিজস্ব Approve, Reject এবং Delete বাটন
    echo "<a href='admin.php?approve=".$report['index']."' class='btn btn-approve'>✔ Approve</a>";
    echo "<a href='admin.php?reject=".$report['index']."' class='btn btn-reject'>✖ Reject</a>";
    echo "<a href='admin.php?delete=".$report['index']."' onclick=\"return confirm('Delete permanently?')\" class='btn btn-delete'>🗑 Delete</a>";
}
?>
</body>
</html>