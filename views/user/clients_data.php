<!-- views/user/clients_data.php -->
<?php 
$pageTitle = 'Client Intelligence Data';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="mb-10 animate-fade-in text-center max-w-2xl mx-auto">
    <div class="w-16 h-16 bg-indigo-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
        <i data-lucide="database" class="w-8 h-8 text-indigo-400"></i>
    </div>
    <h1 class="text-4xl font-black text-white tracking-tight">Client <span class="text-indigo-400">Intelligence</span></h1>
    <p class="text-slate-500 font-medium mt-2 leading-relaxed">
        Access real-time lead sheets, market data, and outreach resources. These links are managed by your administrator.
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
    <?php if (empty($buttons)): ?>
        <div class="col-span-full py-20 text-center glass-card rounded-[40px] border border-dashed border-white/10">
            <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">No active data links available</p>
        </div>
    <?php else: ?>
        <?php foreach ($buttons as $btn): ?>
            <a href="<?php echo e($btn['url']); ?>" target="_blank" class="glass-card p-10 rounded-[40px] border border-white/5 hover:border-indigo-500/30 hover:-translate-y-2 transition-all group relative overflow-hidden">
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-30 transition-opacity">
                    <i data-lucide="external-link" class="w-12 h-12 text-white"></i>
                </div>
                <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center mb-6 border border-white/5 group-hover:bg-indigo-600 transition-colors">
                    <i data-lucide="sheet" class="w-6 h-6 text-slate-400 group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-100 mb-2"><?php echo e($btn['label']); ?></h3>
                <p class="text-slate-500 text-sm font-medium">Access Data Stream &rarr;</p>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
