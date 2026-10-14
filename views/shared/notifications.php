<!-- views/shared/notifications.php -->
<?php 
$pageTitle = 'Alert Intelligence';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
    <div>
        <a href="<?php echo is_admin() ? url('Admin/dashboard.php') : url('User/dashboard.php'); ?>" class="group flex items-center text-slate-500 hover:text-indigo-400 transition-all mb-4">
            <i data-lucide="chevron-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
            <span class="text-[10px] font-black uppercase tracking-[3px]">Back to Console</span>
        </a>
        <h3 class="text-3xl font-black text-slate-100 mt-2 tracking-tight">Intelligence <span class="text-indigo-500">Chronicle</span></h3>
        <p class="text-slate-400 text-sm font-medium">Full historical audit of system signals and protocol alerts.</p>
    </div>
    <?php if (!empty($notifications)): ?>
    <button onclick="markAllRead()" class="h-11 px-6 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-500/20 transition-all flex items-center shadow-lg shadow-indigo-500/5">
        <i data-lucide="check-check" class="w-4 h-4 mr-2"></i>
        Acknowledge All
    </button>
    <?php endif; ?>
</div>

<div class="space-y-4 max-w-4xl mx-auto">
    <?php if (!empty($notifications)): ?>
        <?php foreach ($notifications as $n): ?>
            <div class="glass-card p-6 rounded-3xl border border-white/5 transition-all hover:border-indigo-500/30 group <?php echo $n['is_read'] ? 'opacity-60' : ''; ?>">
                <div class="flex items-start gap-5">
                    <div class="w-12 h-12 rounded-2xl bg-<?php 
                        echo ($n['type'] === 'success' ? 'emerald' : ($n['type'] === 'danger' ? 'red' : ($n['type'] === 'warning' ? 'orange' : 'indigo'))); 
                    ?>-500/10 flex items-center justify-center shrink-0 border border-<?php 
                        echo ($n['type'] === 'success' ? 'emerald' : ($n['type'] === 'danger' ? 'red' : ($n['type'] === 'warning' ? 'orange' : 'indigo'))); 
                    ?>-500/20">
                        <i data-lucide="<?php 
                            echo ($n['type'] === 'success' ? 'check-circle' : ($n['type'] === 'danger' ? 'alert-octagon' : ($n['type'] === 'warning' ? 'help-circle' : 'info'))); 
                        ?>" class="w-6 h-6 text-<?php 
                            echo ($n['type'] === 'success' ? 'emerald' : ($n['type'] === 'danger' ? 'red' : ($n['type'] === 'warning' ? 'orange' : 'indigo'))); 
                        ?>-400"></i>
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="text-lg font-black text-slate-100 group-hover:text-indigo-400 transition-colors tracking-tight">
                                <?php echo e($n['title']); ?>
                            </h4>
                            <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest bg-white/5 px-3 py-1 rounded-full">
                                <?php echo date('M d, H:i', strtotime($n['created_at'])); ?>
                            </span>
                        </div>
                        <p class="text-sm font-medium text-slate-400 leading-relaxed mb-4">
                            <?php echo e($n['message']); ?>
                        </p>
                        
                        <?php if (!$n['is_read']): ?>
                            <div class="flex items-center gap-2 text-[10px] font-black text-indigo-400 uppercase tracking-[2px]">
                                <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-pulse"></span>
                                New Intelligence
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center py-24 glass-card rounded-[40px] border-dashed border-white/10">
            <div class="w-20 h-20 bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-6 opacity-30">
                <i data-lucide="bell-off" class="w-10 h-10 text-slate-500"></i>
            </div>
            <h3 class="text-xl font-black text-slate-300">Quiet Sector</h3>
            <p class="text-sm text-slate-500 font-medium">No system alerts have been logged for your identity.</p>
        </div>
    <?php endif; ?>
</div>

<script>
lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
