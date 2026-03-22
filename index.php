<?php
require_once __DIR__ . '/config.php';
$_SESSION['login_role'] = 'visitor'; 

$error = $_GET['error'] ?? '';
$google_login_url = $client->createAuthUrl(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEU Library - Visitor Log</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('BG LIB.jpg') no-repeat center center fixed; background-size: cover; }
        .glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); position: relative; }
        .tab-active { border-bottom: 3px solid #1D4ED8; color: #1D4ED8; }
        .google-btn { transition: all 0.3s ease; border: 1px solid #e2e8f0; }
        .google-btn:hover { background-color: #f8fafc; border-color: #cbd5e1; transform: translateY(-1px); }
        
        /* Floating Admin Button Style */
        .admin-float {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
        }
        .admin-float:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }
    </style>
</head>
<body id="mainBody" class="flex items-center justify-center min-h-screen p-6 relative">

    <div class="absolute top-8 left-8">
        <a href="admin_login.php" class="admin-float flex items-center gap-3 px-4 py-3 rounded-2xl text-white border border-white/20 shadow-xl group" title="Admin Portal">
            <i class="fas fa-user-shield text-xl group-hover:text-blue-400 transition-colors"></i>
            <span class="text-[10px] font-black uppercase tracking-[0.2em]">Admin Portal</span>
        </a>
    </div>

    <div class="absolute top-8 right-8 text-right text-white drop-shadow-lg">
        <div id="digitalClock" class="text-3xl font-black tracking-tighter">00:00:00 AM</div>
        <div id="digitalDay" class="text-xs font-bold uppercase tracking-[0.2em] opacity-80">Monday, January 01</div>
    </div>

    <div class="glass p-8 rounded-[35px] shadow-2xl w-full max-w-md border border-white/20">
        
        <div class="text-center mb-6">
            <img src="neu.png" class="w-16 mx-auto mb-3" alt="NEU Logo">
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Library Visitor Log</h1>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">New Era University</p>
        </div>

        <?php if($error): ?>
            <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 text-xs font-bold border border-red-100">
                ⚠️ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="mb-6">
            <a href="<?php echo $google_login_url; ?>" class="google-btn flex items-center justify-center w-full bg-white py-3.5 rounded-2xl text-sm font-bold shadow-sm group">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-5 h-5 mr-3" alt="Google">
                Sign in with @neu.edu.ph
            </a>
            <div class="flex items-center my-6">
                <div class="flex-grow h-[1px] bg-slate-200"></div>
                <span class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Or Manual Entry</span>
                <div class="flex-grow h-[1px] bg-slate-200"></div>
            </div>
        </div>

        <div class="flex border-b border-slate-100 mb-6">
            <button onclick="switchTab('tap')" id="tabTap" class="flex-1 py-3 text-xs font-black uppercase tracking-widest tab-active transition-all">Tap ID</button>
            <button onclick="switchTab('manual')" id="tabManual" class="flex-1 py-3 text-xs font-black uppercase tracking-widest text-slate-400 transition-all">Form</button>
        </div>

        <div id="sectionTap" class="text-center py-6">
            <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                <span class="text-4xl">🪪</span>
            </div>
            <p class="text-sm font-bold text-slate-600">Please tap your ID on the reader</p>
            <button onclick="simulateTap()" class="mt-8 text-[10px] font-black text-blue-600 hover:underline uppercase tracking-widest opacity-50">Simulate NFC Tap</button>
        </div>

        <form id="sectionManual" action="process_log.php" method="POST" class="hidden space-y-4">
            <div class="flex gap-2 mb-4">
                <label class="flex-1 cursor-pointer">
                    <input type="radio" name="user_type" value="STUDENT" checked class="hidden peer">
                    <div class="py-2 border-2 border-slate-100 rounded-xl text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                        <span class="text-[9px] font-black text-slate-500 peer-checked:text-blue-600 uppercase tracking-widest">Student</span>
                    </div>
                </label>
                <label class="flex-1 cursor-pointer">
                    <input type="radio" name="user_type" value="EMPLOYEE" class="hidden peer">
                    <div class="py-2 border-2 border-slate-100 rounded-xl text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                        <span class="text-[9px] font-black text-slate-500 peer-checked:text-blue-600 uppercase tracking-widest">Employee</span>
                    </div>
                </label>
            </div>

            <input type="text" name="name" required placeholder="FULL NAME" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-5 text-sm font-bold focus:ring-2 focus:ring-blue-600 outline-none transition-all">
            <input type="email" 
                name="email" 
                required 
                placeholder="NEU EMAIL (@neu.edu.ph)" 
                pattern="[a-z0-9._%+-]+@neu\.edu\.ph$" 
                title="Please use your official @neu.edu.ph email address."
                class="w-full bg-slate-50 border-none rounded-2xl py-4 px-5 text-sm font-bold focus:ring-2 focus:ring-blue-600 outline-none transition-all">            
            <div class="relative">
                <input type="text" name="department" list="depts" required placeholder="COLLEGE / DEPARTMENT" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-5 text-sm font-bold focus:ring-2 focus:ring-blue-600 outline-none transition-all">
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

            <input type="text" name="purpose" list="purposes" required placeholder="PURPOSE OF VISIT" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-5 text-sm font-bold focus:ring-2 focus:ring-blue-600 outline-none transition-all">
            <datalist id="purposes">
                <option value="Research">
                <option value="Study">
                <option value="Borrowing Books">
                <option value="Reviewing">
            </datalist>
            
            <button type="submit" class="w-full bg-blue-700 text-white py-4 rounded-2xl text-sm font-black shadow-lg hover:bg-blue-800 transition-all mt-4">LOG VISIT →</button>
        </form>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
            const dayStr = now.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: '2-digit' });
            document.getElementById('digitalClock').innerText = timeStr;
            document.getElementById('digitalDay').innerText = dayStr;
        }
        setInterval(updateClock, 1000);
        updateClock();

        function switchTab(type) {
            const tapSec = document.getElementById('sectionTap'); const manualSec = document.getElementById('sectionManual');
            const tapTab = document.getElementById('tabTap'); const manualTab = document.getElementById('tabManual');
            if(type === 'tap') {
                tapSec.classList.remove('hidden'); manualSec.classList.add('hidden');
                tapTab.classList.add('tab-active'); tapTab.classList.remove('text-slate-400');
                manualTab.classList.remove('tab-active'); manualTab.classList.add('text-slate-400');
            } else {
                tapSec.classList.add('hidden'); manualSec.classList.remove('hidden');
                manualTab.classList.add('tab-active'); manualTab.classList.remove('text-slate-400');
                tapTab.classList.remove('tab-active'); tapTab.classList.add('text-slate-400');
            }
        }
    </script>
</body>
</html>