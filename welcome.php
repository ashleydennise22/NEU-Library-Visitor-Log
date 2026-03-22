<?php
// 1. SET TIMEZONE
date_default_timezone_set('Asia/Manila');

require_once 'config.php';

// 2. KUNIN ANG DATA GALING SA URL (GET)
// Ginamit natin ang 'dept' dahil ito ang parameter name sa redirection
$name = $_GET['name'] ?? 'Visitor';
$department = $_GET['dept'] ?? 'Not Specified'; 
$purpose = $_GET['purpose'] ?? 'General Visit';
$user_type = $_GET['user_type'] ?? 'STUDENT';

// 3. KUNIN ANG TIME GALING SA URL, KUNG WALA, GAMITIN ANG CURRENT TIME
$time = $_GET['time'] ?? date('F d, Y | h:i A'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back | NEU Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: url('BG LIB.jpg') no-repeat center center fixed; background-size: cover; }
        .overlay { background: rgba(0, 0, 0, 0.4); position: fixed; inset: 0; }
        .glass-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6">
    <div class="overlay"></div>
    
    <div class="relative glass-container p-12 md:p-16 rounded-[40px] shadow-2xl text-center max-w-4xl w-full overflow-hidden">
        <img src="neu.png" class="w-20 mx-auto mb-6" alt="NEU Logo">
        
        <div class="mb-2">
            <span class="px-4 py-1 bg-green-100 text-green-700 text-[10px] font-black rounded-full uppercase tracking-widest">Login Successful</span>
        </div>
        <h1 class="text-5xl font-black text-slate-800 mb-8 leading-tight">Welcome to NEU Library!</h1>
        
        <div class="w-20 h-1.5 bg-blue-600 mx-auto mb-10 rounded-full"></div>
        
        <div class="flex flex-col md:flex-row items-center justify-around bg-slate-50 rounded-[30px] p-10 mb-10 border border-slate-100">
            <div class="mb-6 md:mb-0 text-center md:text-left">
                <span class="px-3 py-1 bg-slate-900 text-white text-[8px] font-black rounded-full uppercase tracking-widest mb-2 inline-block"><?php echo htmlspecialchars($user_type); ?></span>
                <h2 class="text-3xl font-black text-slate-900 leading-tight"><?php echo htmlspecialchars($name); ?></h2>
                <p class="text-slate-500 font-bold text-sm uppercase tracking-wider"><?php echo htmlspecialchars($department); ?></p>
            </div>

            <div class="hidden md:block w-px h-20 bg-slate-200 mx-4"></div>

            <div class="text-center md:text-left">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Purpose of Visit</p>
                <p class="text-blue-700 font-black text-2xl uppercase mb-2"><?php echo htmlspecialchars($purpose); ?></p>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    <i class="far fa-clock mr-1 text-blue-500"></i> <?php echo htmlspecialchars($time); ?>
                </div>
            </div>
        </div>

        <div class="max-w-xs mx-auto">
            <a href="index.php" class="inline-block w-full py-5 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-slate-800 transition-all shadow-lg hover:scale-105">Done</a>
        </div>
        <p class="text-[8px] text-slate-300 mt-12 font-bold uppercase tracking-widest">New Era University © 2026</p>
    </div>

    <script>setTimeout(function() { window.location.href = "index.php"; }, 8000);</script>
</body>
</html>