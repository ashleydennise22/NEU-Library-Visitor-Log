<?php
require_once 'config.php'; //

// Kung naka-login na ang admin, skip ang login page
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit();
}

// Itakda ang login role bilang admin
$_SESSION['login_role'] = 'admin';

$login_url = $client->createAuthUrl();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian Login | NEU Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            background: linear-gradient(rgba(15,23,42,0.85), rgba(15,23,42,0.85)), url('BG LIB.jpg') no-repeat center center fixed; 
            background-size: cover; 
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white/95 backdrop-blur-md p-10 rounded-[40px] shadow-2xl w-full max-w-sm border border-white/20 transition-all">
        
        <div class="text-center mb-8">
            <img src="neu.png" class="w-20 mx-auto mb-4 drop-shadow-xl" alt="NEU Logo">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Admin Portal</h1>
            <p class="text-slate-500 text-sm font-medium mt-2">Sign in with your @neu.edu.ph account</p>
        </div>

        <div class="space-y-4">
            <a href="<?php echo $login_url; ?>" class="flex items-center justify-center w-full bg-white border border-slate-200 text-slate-700 py-3.5 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-50 hover:border-blue-400 transition-all active:scale-95 group">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" alt="Google Icon">
                Login with Google
            </a>
        </div>

        <div class="mt-10 pt-6 border-t border-slate-100">
            <a href="index.php" class="block text-center text-blue-600 text-xs font-bold hover:text-blue-800 hover:underline transition-colors uppercase tracking-tight">
                ← Back to Visitor Log
            </a>
        </div>
    </div>
</body>
</html>