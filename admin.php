<?php
// admin.php
session_start(); // Siguraduhing may session_start() sa pinakataas!
require_once 'config.php';

// Mas mahigpit na security check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Kung hindi valid ang session, i-destroy ito para malinis
    session_unset();
    session_destroy();
    header("Location: admin_login.php");
    exit();
}

// 2. GET FILTER & SEARCH INPUTS
$start_date = $_GET['start'] ?? date('Y-m-d', strtotime('-7 days'));
$end_date   = $_GET['end']   ?? date('Y-m-d');
$f_purpose  = $_GET['f_purpose'] ?? '';
$f_dept     = $_GET['f_dept'] ?? '';
$f_type     = $_GET['f_type'] ?? ''; 
$search     = $_GET['search'] ?? '';

// 3. STATISTICS
$today_count = $conn->query("SELECT COUNT(*) as total FROM visitors WHERE DATE(login_time) = CURDATE()")->fetch_assoc()['total'];
$week_count  = $conn->query("SELECT COUNT(*) as total FROM visitors WHERE login_time >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetch_assoc()['total'];

// DITO NAGDAGDAG NG BLOCKED USERS QUERY
// Ang 'blocked' ay status sa visitors table
$blocked_result = $conn->query("SELECT COUNT(*) as total FROM visitors WHERE status = 'blocked'");
if (!$blocked_result) {
    // Pag walang 'status' column, gumawa muna sa SQL
    $blocked_count = 0; 
} else {
    $blocked_count = $blocked_result->fetch_assoc()['total'];
}

// 4. DYNAMIC QUERY
$where = "WHERE DATE(login_time) BETWEEN '$start_date' AND '$end_date'";

if ($f_purpose) $where .= " AND purpose = '" . $conn->real_escape_string($f_purpose) . "'";
if ($f_dept)    $where .= " AND department = '" . $conn->real_escape_string($f_dept) . "'";
if ($f_type)    $where .= " AND UPPER(user_type) = UPPER('" . $conn->real_escape_string($f_type) . "')";

if ($search) {
    $s = $conn->real_escape_string($search);
    $where .= " AND (name LIKE '%$s%' 
                OR user_type LIKE '%$s%' 
                OR department LIKE '%$s%' 
                OR purpose LIKE '%$s%'
                OR email LIKE '%$s%')";
}

// admin.php (Line 43-45 approx)
$result = $conn->query("SELECT * FROM visitors $where ORDER BY login_time DESC");
$range_count = $result->num_rows;

$dept_query = $conn->query("SELECT DISTINCT department FROM visitors ORDER BY department ASC");
?>

<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | NEU Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
</head>
<body class="bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-300 font-sans">

    <nav class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-8 py-4 sticky top-0 z-50 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <img src="neu.png" class="w-10" alt="NEU Logo">
            <div>
                <h1 class="text-lg font-black text-slate-800 dark:text-white leading-none">NEU Library</h1>
                <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Administrator</p>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <button onclick="toggleDarkMode()" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-lg" id="modeIcon">🌙</button>
            <div class="h-8 w-[1px] bg-slate-200 dark:border-slate-700"></div>
            <a href="logout.php" class="bg-red-50 dark:bg-red-900/20 text-red-600 px-4 py-2 rounded-xl text-xs font-black hover:bg-red-100 transition-all uppercase">Logout</a>
        </div>
    </nav>

    <main class="p-8 max-w-7xl mx-auto">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-600 p-8 rounded-[35px] text-white shadow-xl shadow-blue-200 transition-all">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-70">Today's Logs</p>
                <h2 class="text-5xl font-black mt-2"><?php echo $today_count; ?></h2>
            </div>
            
            <div class="bg-red-600 p-8 rounded-[35px] text-white shadow-xl shadow-red-200 transition-all">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-70">Blocked Users</p>
                <h2 class="text-5xl font-black mt-2"><?php echo $blocked_count; ?></h2>
            </div>

            <div class="bg-white dark:bg-slate-900 p-8 rounded-[35px] border border-slate-200 dark:border-slate-800 shadow-sm transition-all">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Past 7 Days</p>
                <h2 class="text-5xl font-black mt-2 text-slate-800 dark:text-white"><?php echo $week_count; ?></h2>
            </div>
            
            <div class="bg-slate-900 dark:bg-blue-900/30 p-8 rounded-[35px] text-white shadow-xl transition-all">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-70">Filtered Results</p>
                <h2 class="text-5xl font-black mt-2"><?php echo $range_count; ?></h2>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-8 rounded-[35px] shadow-sm border border-slate-200 dark:border-slate-800 mb-8 transition-all">
            <form method="GET" class="flex flex-col gap-6">
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">🔍</span>
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
                           placeholder="Search name, type, college, or purpose..." 
                           class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-[20px] py-4 pl-12 pr-4 text-sm font-bold dark:text-white focus:ring-2 focus:ring-blue-500 transition-all shadow-inner">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
                    
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1">Date Period</label>
                        <div class="flex items-center bg-slate-50 dark:bg-slate-800 rounded-xl overflow-hidden p-1 border border-transparent focus-within:border-blue-500 transition-all">
                            <input type="date" name="start" value="<?php echo $start_date; ?>" class="w-full bg-transparent border-none p-2 text-xs font-bold dark:text-white focus:ring-0">
                            <span class="text-slate-300 px-2 font-black italic">to</span>
                            <input type="date" name="end" value="<?php echo $end_date; ?>" class="w-full bg-transparent border-none p-2 text-xs font-bold dark:text-white focus:ring-0">
                        </div>
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1">User Type</label>
                        <select name="f_type" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl p-3 text-xs font-bold dark:text-white">
                            <option value="">All Types</option>
                            <option value="STUDENT" <?php if(strtoupper($f_type)=='STUDENT') echo 'selected'; ?>>Student</option>
                            <option value="EMPLOYEE" <?php if(strtoupper($f_type)=='EMPLOYEE') echo 'selected'; ?>>Employee</option>
                        </select>
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1">College</label>
                        <select name="f_dept" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl p-3 text-xs font-bold dark:text-white">
                            <option value="">All Colleges</option>
                            <option value="CA">College of Accountancy</option>
                            <option value="CAG">College of Agriculture</option>
                            <option value="CAS">College of Arts and Sciences</option>
                            <option value="CBA">College of Business Administration</option>
                            <option value="COC">College of Communication</option>
                            <option value="CICS">College of Informatics & Computing Studies</option>
                            <option value="CC">College of Criminology</option>
                            <option value="CED">College of Education</option>
                            <option value="CEA">College of Engineering and Architecture</option>
                            <option value="CMT">College of Medical Technology</option>
                            <option value="CM">College of Midwifery</option>
                            <option value="CMU">College of Music</option>
                            <option value="CON">College of Nursing</option>
                            <option value="CPT">College of Physical Therapy</option>
                            <option value="CRT">College of Respiratory Therapy</option>
                            <option value="SIR">School of International Relations</option>
                        </select>
                    </div>

                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1">Purpose</label>
                        <select name="f_purpose" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl p-3 text-xs font-bold dark:text-white">
                            <option value="">All Reasons</option>
                            <option value="Study" <?php if($f_purpose=='Study') echo 'selected'; ?>>Study</option>
                            <option value="Research" <?php if($f_purpose=='Research') echo 'selected'; ?>>Research</option>
                            <option value="Reading" <?php if($f_purpose=='Reading') echo 'selected'; ?>>Reading</option>
                            <option value="Borrowing Books" <?php if($f_purpose=='Borrowing Books') echo 'selected'; ?>>Borrowing Books</option>
                            <option value="Computer Use" <?php if($f_purpose=='Computer Use') echo 'selected'; ?>>Computer Use</option>
                            <option value="Writing" <?php if($f_purpose=='Writing') echo 'selected'; ?>>Writing</option>
                            <option value="Reviewing" <?php if($f_purpose=='Reviewing') echo 'selected'; ?>>Reviewing</option>
                        </select>
                    </div>

                    <div class="md:col-span-1">
                        <button type="submit" class="w-full bg-blue-600 text-white p-3.5 rounded-xl text-[10px] font-black hover:bg-blue-700 shadow-lg transition-all uppercase tracking-tighter">
                            Apply
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-[35px] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/30 dark:bg-slate-800/20">
                <h3 class="font-black text-slate-800 dark:text-white uppercase tracking-tighter">Library Visitor Logs</h3>
                <a href="export_excel.php" class="text-[10px] font-black text-green-600 hover:bg-green-50 px-4 py-2 rounded-lg transition-all">EXPORT EXCEL</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 dark:bg-slate-800/50 text-[10px] font-black text-slate-400 uppercase">
                        <tr>
                            <th class="px-8 py-4">Visitor Information</th>
                            <th class="px-8 py-4">College/Department</th>
                            <th class="px-8 py-4">Purpose</th>
                            <th class="px-8 py-4">Check-in Time</th>
                            <th class="px-8 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr class="text-sm group hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-all">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <?php 
                                            // Detection Logic
                                            $dbValue = trim(strtoupper($row['user_type']));
                                            $isStudent = ($dbValue === 'STUDENT');
                                            $dotColor = $isStudent ? 'bg-blue-500 shadow-blue-200' : 'bg-amber-500 shadow-amber-200';
                                            $badgeColor = $isStudent ? 'bg-blue-50 text-blue-600' : 'bg-amber-50 text-amber-600';
                                        ?>
                                        <div class="w-2.5 h-2.5 rounded-full <?php echo $dotColor; ?> shadow-lg transition-all group-hover:scale-125"></div>
                                        <div>
                                            <p class="font-bold text-slate-800 dark:text-white flex items-center gap-2">
                                                <?php echo htmlspecialchars($row['name']); ?>
                                                <span class="text-[9px] px-2 py-0.5 rounded-md font-black uppercase <?php echo $badgeColor; ?>">
                                                    <?php echo htmlspecialchars($row['user_type']); ?>
                                                </span>
                                            </p>
                                            <p class="text-[10px] text-slate-400 font-medium"><?php echo htmlspecialchars($row['email']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 font-bold text-slate-600 dark:text-slate-400 uppercase text-xs">
                                    <?php echo htmlspecialchars($row['department']); ?>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-[10px] font-bold text-slate-500 italic">
                                        <?php echo htmlspecialchars($row['purpose']); ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5 font-bold text-slate-400 group-hover:text-blue-500 transition-colors">
                                    <?php echo date('M d, Y • h:i A', strtotime($row['login_time'])); ?>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <?php 
                                        // Kunin ang status, default ay 'active' kung NULL
                                        $currentStatus = $row['status'] ?? 'active'; 
                                        $isBlocked = ($currentStatus === 'blocked');
                                    ?>
                                    <button 
                                        onclick="confirmToggle('<?php echo $row['id']; ?>', '<?php echo $currentStatus; ?>', '<?php echo addslashes($row['name']); ?>')" 
                                        class="inline-block px-4 py-2 rounded-xl text-[10px] font-black transition-all shadow-sm
                                        <?php echo $isBlocked 
                                            ? 'bg-green-100 text-green-700 hover:bg-green-600 hover:text-white' 
                                            : 'bg-red-50 text-red-600 hover:bg-red-600 hover:text-white'; ?>">
                                        <?php echo $isBlocked ? 'UNBLOCK' : 'BLOCK'; ?>
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center text-slate-300 font-black italic uppercase tracking-widest text-xs">
                                    No records found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            document.getElementById('modeIcon').innerText = isDark ? '☀️' : '🌙';
        }
        // admin.php (Sa dulo ng file)
        function confirmToggle(id, currentStatus, name) {
            const isBlocked = (currentStatus === 'blocked');
            const actionText = isBlocked ? 'Unblock' : 'Block';
            const themeColor = isBlocked ? '#059669' : '#dc2626'; // Green if unblocking, Red if blocking

            Swal.fire({
                title: `<span style="font-family:sans-serif font-weight:900">${actionText.toUpperCase()} ${name.toUpperCase()}?</span>`,
                text: isBlocked ? "Allow this user to access the library again?" : "This user will be restricted from entering the library system.",
                icon: isBlocked ? 'info' : 'warning',
                showCancelButton: true,
                confirmButtonColor: themeColor,
                cancelButtonColor: '#94a3b8',
                confirmButtonText: `Yes, ${actionText} User`,
                cancelButtonText: 'Cancel',
                borderRadius: '20px'
            }).then((result) => {
                if (result.isConfirmed) {
                // Ito ang magpapadala ng command sa PHP processor
                window.location.href = `toggle_status.php?id=${id}&current_status=${currentStatus}`;
                }
            });
        }
    </script>
</body>
</html>