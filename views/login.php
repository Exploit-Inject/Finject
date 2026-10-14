<!-- views/login.php -->
<?php 
$pageTitle = 'Authentication';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="min-h-[85vh] flex items-center justify-center p-4">
    <!-- Background Accents -->
    <div class="fixed top-1/4 -left-20 w-80 h-80 bg-indigo-600/10 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="fixed bottom-1/4 -right-20 w-80 h-80 bg-purple-600/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="glass-card p-10 lg:p-14 rounded-3xl w-full max-w-lg relative z-10">
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-indigo-500/20">
                <i data-lucide="shield-check" class="w-8 h-8 text-white"></i>
            </div>
            <h1 class="text-4xl font-black tracking-tighter mb-2">Welcome Back</h1>
            <p class="text-slate-500 font-medium">Access your team finance dashboard.</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-2xl mb-8 flex items-center gap-3 animate-fade-in">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                <span class="text-sm font-bold tracking-tight"><?php echo e($error); ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo url('User/login.php?type=' . ($_GET['type'] ?? 'user')); ?>" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            
            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Email / Username</label>
                <div class="relative">
                    <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500"></i>
                    <input type="email" name="email" required 
                        class="w-full bg-slate-900 border border-white/5 rounded-2xl py-4 pl-12 pr-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-200"
                        placeholder="name@company.com">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Password</label>
                <div class="relative">
                    <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500"></i>
                    <input type="password" name="password" required 
                        class="w-full bg-slate-900 border border-white/5 rounded-2xl py-4 pl-12 pr-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-200"
                        placeholder="••••••••">
                </div>
            </div>

            <button type="submit" 
                class="w-full h-14 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-600/30 flex items-center justify-center gap-3">
                <span>Sign In Securely</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </button>
        </form>

        <div class="mt-12 text-center pt-8 border-t border-white/5">
            <p class="text-sm font-bold text-slate-500 mb-2">
                Switch to <?php echo ($_GET['type'] ?? '') === 'admin' ? '<a href="' . url('User/login.php') . '" class="text-indigo-400 hover:text-indigo-300">Member Portal</a>' : '<a href="' . url('Admin/login.php') . '" class="text-indigo-400 hover:text-indigo-300">Admin Console</a>'; ?>
            </p>
            <p class="text-xs font-bold text-slate-600">
                New here? <a href="<?php echo url('register.php'); ?>" class="text-slate-400 hover:text-white transition-colors">Apply for Membership</a>
            </p>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
