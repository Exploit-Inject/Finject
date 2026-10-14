<!-- views/register.php -->
<?php 
$pageTitle = 'Create Account';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="min-h-[85vh] flex items-center justify-center p-4">
    <div class="glass-card p-10 lg:p-14 rounded-3xl w-full max-w-2xl relative z-10">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black tracking-tighter mb-2">Join the Team</h1>
            <p class="text-slate-500 font-medium">Create your agent account to get started.</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-2xl mb-8 flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                <span class="text-sm font-bold tracking-tight"><?php echo e($error); ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo url('register'); ?>" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            
            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Display Name</label>
                <input type="text" name="name" required class="w-full bg-slate-900 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-200" placeholder="Agent X">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Full Name</label>
                <input type="text" name="full_name" required class="w-full bg-slate-900 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-200" placeholder="John Doe">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Login Email</label>
                <input type="email" name="email" required class="w-full bg-slate-900 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-200" placeholder="login@finject.com">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Personal Email</label>
                <input type="email" name="personal_email" required class="w-full bg-slate-900 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-200" placeholder="personal@gmail.com">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">WhatsApp Number</label>
                <input type="text" name="whatsapp_number" required class="w-full bg-slate-900 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-200" placeholder="+91 ...">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Phone Number</label>
                <input type="text" name="phone_number" required class="w-full bg-slate-900 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-200" placeholder="+91 ...">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Login Password</label>
                <input type="password" name="password" required class="w-full bg-slate-900 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-200" placeholder="••••••••">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Confirm Password</label>
                <input type="password" name="confirm_password" required class="w-full bg-slate-900 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all font-medium text-slate-200" placeholder="••••••••">
            </div>

            <div class="md:col-span-2 pt-6">
                <button type="submit" class="w-full h-14 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-600/30 flex items-center justify-center gap-3">
                    <span>Create My Account</span>
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                </button>
            </div>
        </form>

        <div class="mt-8 text-center pt-8 border-t border-white/5">
            <p class="text-sm font-bold text-slate-500">
                Already have an account? <a href="<?php echo url('login'); ?>" class="text-indigo-400 hover:text-indigo-300">Sign In</a>
            </p>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
