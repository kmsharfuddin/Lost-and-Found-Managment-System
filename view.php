<?php
$file = "data/reports.txt";

/* DELETE FUNCTION */
if(isset($_GET['delete'])){
    if(file_exists($file)){
        $lines = file($file);
        
        // যে ইনডেক্সটা ডিলিট করতে বলা হয়েছে, সেটা ফাইল থেকে রিমুভ হবে
        if(isset($lines[$_GET['delete']])){
            unset($lines[$_GET['delete']]);
            file_put_contents($file, implode("", $lines));
        }
    }
    header("Location:view.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Reports</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f4f6f9; color: #333; }
        .report-box { border:1px solid #ccc; padding:15px; margin:15px 0; background:#fff; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .pair-container { border: 2px dashed #2ecc71; padding: 15px; margin: 20px 0; background: #f0fff4; border-radius: 8px; }
        .pair-title { color: #27ae60; margin-bottom: 10px; font-weight: bold; font-size: 1.1em; }
        .flex-grid { display: flex; gap: 15px; }
        .flex-col { flex: 1; border: 1px solid #ddd; padding: 15px; background: #fff; border-radius: 4px; }
        .delete-btn { color: red; text-decoration: none; font-weight: bold; display: inline-block; margin-top: 10px; }
        @media (max-width: 768px) { .flex-grid { flex-direction: column; } }
    </style>
</head>

<body>

<h2>📋 All Reports</h2>
<a href="dashboard.php" style="text-decoration:none; background:#34495e; color:#fff; padding:5px 10px; border-radius:3px;">⬅ Dashboard</a>
<hr>

<?php
if(!file_exists($file) || filesize($file) == 0){
    echo "No reports yet.";
    exit();
}

$lines = file($file);

$lost_reports = [];
$found_reports = [];
$other_reports = [];

foreach($lines as $index => $line){
    
    // কোনো লাইনে যদি পাইপ (|) না থাকে অথবা পিএইচপি কোড ঢুকে থাকে, সেটা বাদ দেবে
    if(strpos($line, '|') === false || strpos($line, '<?php') !== false || strpos($line, '$_SESSION') !== false) {
        continue; 
    }

    $data = explode("|", trim($line));
    if(count($data) < 3) continue; // ডাটা ভাঙা হলে স্কিপ করবে

    /* SAFE DATA (আপনার বর্তমান view.php এর ৮টি কলামের ফরম্যাট অনুযায়ী সাজানো) */
    $type     = trim($data[0] ?? "");
    $title    = trim($data[1] ?? "");
    $desc     = trim($data[2] ?? "");
    $status   = trim($data[3] ?? "Pending");
    $user     = trim($data[4] ?? "");
    $phone    = trim($data[5] ?? "");
    $location = trim($data[6] ?? "");
    $date     = trim($data[7] ?? "");

    // রিপোর্টের পুরো ডাটা এবং ফাইলের আসল লাইনের ইনডেক্স একসাথে সেভ রাখছি (ডিলিট করার জন্য)
    $report_data = [
        'index'    => $index,
        'type'     => $type,
        'title'    => $title,
        'desc'     => $desc,
        'status'   => $status,
        'user'     => $user,
        'phone'    => $phone,
        'location' => $location,
        'date'     => $date
    ];

    // টাইপ অনুযায়ী ভাগ করা
    $type_lower = strtolower($type);
    if($type_lower == 'lost'){
        $lost_reports[] = $report_data;
    } elseif($type_lower == 'found') {
        $found_reports[] = $report_data;
    } else {
        $other_reports[] = $report_data;
    }
}

// Lost এবং Found ম্যাচিং বা পেয়ারিং লজিক
$matched_lost_indices = [];
$matched_found_indices = [];
$pairs = [];

foreach($lost_reports as $l_key => $lost){
    foreach($found_reports as $f_key => $found){
        if(in_array($f_key, $matched_found_indices)) continue;

        // যদি হারানো ও পাওয়া জিনিসের টাইটেল (Item Name) মিলে যায় তবে জোড়া তৈরি হবে
        if(strtolower($lost['title']) == strtolower($found['title'])){
            $pairs[] = [
                'lost'  => $lost,
                'found' => $found
            ];
            $matched_lost_indices[] = $l_key;
            $matched_found_indices[] = $f_key;
            break; 
        }
    }
}

/* === ১. স্ক্রিনে ম্যাচিং পেয়ারগুলো পাশাপাশি দেখানো === */
if(!empty($pairs)){
    echo "<h3>🤝 Matched Pairs (Lost & Found)</h3>";
    foreach($pairs as $pair){
        echo "<div class='pair-container'>";
        echo "<div class='pair-title'>✅ Potential Match Found! (Item: ".$pair['lost']['title'].")</div>";
        echo "<div class='flex-grid'>";
            
            // Lost কলাম
            echo "<div class='flex-col' style='border-left: 5px solid #e74c3c;'>";
            echo "<span style='color:#e74c3c; font-weight:bold;'>🔴 LOST REPORT</span><br><br>";
            displaySingleBlock($pair['lost']);
            echo "</div>";

            // Found কলাম
            echo "<div class='flex-col' style='border-left: 5px solid #3498db;'>";
            echo "<span style='color:#3498db; font-weight:bold;'>🔵 FOUND REPORT</span><br><br>";
            displaySingleBlock($pair['found']);
            echo "</div>";

        echo "</div>";
        echo "</div>";
    }
}

/* === ২. যে রিপোর্টগুলো ম্যাচ হয়নি বা সিঙ্গেল, সেগুলো নিচে দেখানো === */
echo "<h3>📌 Unmatched / Single Reports</h3>";

foreach($lost_reports as $l_key => $lost){
    if(in_array($l_key, $matched_lost_indices)) continue;
    echo "<div class='report-box' style='border-left: 5px solid #e74c3c;'>";
    echo "<span style='color:#e74c3c; font-weight:bold;'>[🔴 UNMATCHED LOST]</span><br><br>";
    displaySingleBlock($lost);
    echo "</div>";
}

foreach($found_reports as $f_key => $found){
    if(in_array($f_key, $matched_found_indices)) continue;
    echo "<div class='report-box' style='border-left: 5px solid #3498db;'>";
    echo "<span style='color:#3498db; font-weight:bold;'>[🔵 UNMATCHED FOUND]</span><br><br>";
    displaySingleBlock($found);
    echo "</div>";
}

foreach($other_reports as $other){
    echo "<div class='report-box'>";
    displaySingleBlock($other);
    echo "</div>";
}

// রিপোর্ট প্রিন্ট করার কমন হেল্পার ফাংশন
function displaySingleBlock($r) {
    echo "📌 Type: <b>".$r['type']."</b><br>";
    echo "🧾 Item: <b>".$r['title']."</b><br>";
    echo "📝 Description: ".$r['desc']."<br>";
    echo "👤 User: ".$r['user']."<br>";
    echo "📞 Phone: ".$r['phone']."<br>";
    echo "📍 Location: ".$r['location']."<br>";
    echo "📅 Date: ".$r['date']."<br>";
    echo "📊 Status: <b>".$r['status']."</b><br><br>";
    
    // ডিলিট করার জন্য ফাইলের অরিজিনাল ইনডেক্স ব্যবহার করা হয়েছে
    echo "<a href='view.php?delete=".$r['index']."' 
          onclick=\"return confirm('Delete report?')\" 
          class='delete-btn'>🗑 Delete</a>";
}
?>

</body>
</html>