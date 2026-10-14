<!-- views/user/tools.php -->
<?php 
$pageTitle = 'Our Arsenal';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="mb-10 animate-fade-in">
    <h1 class="text-4xl font-black text-white tracking-tight">The <span class="text-indigo-400">Toolkit</span></h1>
    <p class="text-slate-500 font-medium mt-2">The software and AI that power our 10x productivity.</p>
</div>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-16">
    <?php foreach ($tools as $tool): ?>
        <div class="glass-card p-6 rounded-[24px] border border-white/5 hover:border-indigo-500/20 transition-all text-center group">
            <div class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/5 group-hover:scale-110 transition-transform">
                <?php if ($tool['name'] === 'GitHub'): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white w-6 h-6"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.28 1.15-.28 2.35 0 3.5-.73 1.02-1.08 2.25-1 3.5 0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"></path><path d="M9 18c-4.51 2-5-2-7-2"></path></svg>
                <?php else: ?>
                    <i data-lucide="<?php echo $tool['icon'] ?: 'settings'; ?>" class="w-6 h-6 text-indigo-400"></i>
                <?php endif; ?>
            </div>
            <h3 class="font-bold text-slate-200 text-sm mb-1"><?php echo $tool['name']; ?></h3>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider"><?php echo $tool['description'] ?: 'Essential Tool'; ?></p>
        </div>
    <?php endforeach; ?>
</div>

<div class="glass-card p-10 rounded-[40px] border border-white/5 bg-gradient-to-br from-indigo-600/5 to-purple-600/5">
    <div class="flex flex-col md:flex-row items-center gap-10">
        <div class="w-20 h-20 bg-indigo-600 rounded-3xl flex items-center justify-center shrink-0 shadow-2xl shadow-indigo-600/20">
            <i data-lucide="zap" class="w-10 h-10 text-white"></i>
        </div>
        <div>
            <h2 class="text-2xl font-black text-white mb-2">Why these tools?</h2>
            <p class="text-slate-500 font-medium leading-relaxed">
                We don't code from scratch. We use <strong>AI-first workflows</strong> to build in minutes what takes others days. 
                Hostinger for deployment, ChatGPT/Claude for logic, and WhatsApp for closing. This toolkit is your unfair advantage.
            </p>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
