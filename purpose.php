<?php
require_once 'config.php';

$name = $_GET['name'] ?? 'Visitor';
$email = $_GET['email'] ?? '';
$dept = $_GET['dept'] ?? ''; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Purpose | NEU Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('BG LIB.jpg') no-repeat center center fixed; 
            background-size: cover; 
            font-family: 'Inter', sans-serif;
        }
        .glass-card { 
            background: rgba(255, 255, 255, 0.95); 
            backdrop-filter: blur(15px); 
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        /* Custom styling para sa input focus */
        .input-focus:focus {
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.2);
            border-color: #1D4ED8;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="glass-card p-8 md:p-10 rounded-[40px] shadow-2xl w-full max-w-lg relative overflow-hidden">
        <div class="text-center mb-6 relative">
            <img src="neu.png" class="w-16 mx-auto mb-4 drop-shadow-sm" alt="NEU Logo">
            <h1 class="text-2xl font-black text-slate-800 tracking-tight text-wrap">Welcome, <?php echo htmlspecialchars($name); ?>!</h1>
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mt-1"><?php echo htmlspecialchars($email); ?></p>
        </div>

        <form action="process_final_log.php" method="POST">
            
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 text-center">Your College / Department</p>
            <div class="mb-8">
                <input type="text" name="dept" list="depts" required 
                    placeholder="TYPE OR SELECT YOUR COLLEGE" 
                    class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl py-3.5 px-5 text-xs font-bold text-slate-700 outline-none input-focus transition-all">
                <datalist id="depts">
                    <option value="College of Accountancy">
                    <option value="College of Agriculture">
                    <option value="College of Arts and Sciences">
                    <option value="College of Business Administration">
                    <option value="College of Communication">
                    <option value="College of Informatics & Computing Studies">
                    <option value="College of Criminology">
                    <option value="College of Education">
                    <option value="College of Engineering and Architecture">
                    <option value="College of Medical Technology">
                    <option value="College of Midwifery">
                    <option value="College of Music">
                    <option value="College of Nursing">
                    <option value="College of Physical Therapy">
                    <option value="College of Respiratory Therapy">
                    <option value="School of International Relations">
                    <option value="K to 12 Integrated School">
                </datalist>
            </div>

            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 text-center">Identify Yourself</p>
            <div class="flex gap-3 mb-8">
                <label class="flex-1 cursor-pointer group">
                    <input type="radio" name="user_type" value="STUDENT" checked class="hidden peer">
                    <div class="p-3 border-2 border-slate-100 rounded-2xl text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                        <i class="fas fa-user-graduate mb-1 block text-slate-400 peer-checked:text-blue-600"></i>
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-tighter">Student</span>
                    </div>
                </label>
                <label class="flex-1 cursor-pointer group">
                    <input type="radio" name="user_type" value="EMPLOYEE" class="hidden peer">
                    <div class="p-3 border-2 border-slate-100 rounded-2xl text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                        <i class="fas fa-user-tie mb-1 block text-slate-400 peer-checked:text-blue-600"></i>
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-tighter">Employee</span>
                    </div>
                </label>
            </div>

            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 text-center">Select Purpose</p>
            <div class="grid grid-cols-3 gap-3 mb-8">
                <?php 
                $purposes = [
                    ['label' => 'Study', 'icon' => 'fa-book-reader'],
                    ['label' => 'Research', 'icon' => 'fa-microscope'],
                    ['label' => 'Reading', 'icon' => 'fa-book-open'],
                    ['label' => 'Borrowing Books', 'icon' => 'fa-book'],
                    ['label' => 'Computer Use', 'icon' => 'fa-desktop'],
                    ['label' => 'Writing', 'icon' => 'fa-pen-nib'],
                ];
                foreach($purposes as $p): ?>
                <label class="cursor-pointer group">
                    <input type="radio" name="purpose" value="<?php echo $p['label']; ?>" class="hidden peer" required>
                    <div class="border-2 border-slate-100 rounded-2xl p-3 h-full flex flex-col items-center justify-center text-center hover:border-blue-200 hover:bg-slate-50 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                        <i class="fas <?php echo $p['icon']; ?> text-slate-400 text-xl mb-2 peer-checked:text-blue-600 transition-colors"></i>
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-tighter leading-tight peer-checked:text-blue-600"><?php echo $p['label']; ?></span>
                    </div>
                </label>
                <?php endforeach; ?>
            </div>

            <input type="hidden" name="name" value="<?php echo htmlspecialchars($name); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

            <button type="submit" class="w-full bg-blue-700 text-white py-4 rounded-2xl text-sm font-black shadow-lg hover:bg-blue-800 transition-all flex items-center justify-center group">
                LOG MY VISIT <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
            </button>
        </form>

        <p class="text-[9px] text-slate-400 text-center mt-8 font-black uppercase tracking-[0.3em] opacity-40">New Era University Library © 2026</p>
    </div>
</body>
</html>
