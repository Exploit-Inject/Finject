<!-- views/user/dashboard.php -->
<?php 
$pageTitle = 'Dashboard Overview';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="mb-10 animate-fade-in">
    <h1 class="text-3xl font-black tracking-tight mb-2">Member <span class="text-purple-500">Dashboard</span></h1>
    <p class="text-slate-400 text-sm font-medium">Tracking your personal contributions and organization growth.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
    <!-- Global Stats (Gradient) -->
    <div class="relative group col-span-1 md:col-span-1">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
        <div class="relative glass-card p-8 rounded-3xl h-full flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-indigo-500/10 text-indigo-400 rounded-2xl flex items-center justify-center mb-6">
                    <i data-lucide="globe" class="w-6 h-6"></i>
                </div>
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[3px] mb-2">Organization Revenue</h3>
                <p class="text-4xl font-black tracking-tighter" data-stat="total_income"><?php echo format_currency($stats['total_income']); ?></p>
            </div>
            <div class="mt-8 flex items-center gap-2 text-[10px] font-black text-indigo-400 uppercase tracking-widest">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-ping"></span>
                Live Performance
            </div>
        </div>
    </div>

    <!-- My Total -->
    <div class="glass-card p-8 rounded-3xl flex flex-col justify-between">
        <div>
            <div class="w-12 h-12 bg-purple-500/10 text-purple-400 rounded-2xl flex items-center justify-center mb-6">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[3px] mb-2">My Contribution</h3>
            <p class="text-4xl font-black tracking-tighter text-purple-400" data-stat="my_total"><?php echo format_currency($stats['my_total']); ?></p>
        </div>
        <div class="mt-8 text-[10px] font-black text-slate-600 uppercase tracking-widest">
            Ranked Active Contributor
        </div>
    </div>

    <!-- Quick Actions List -->
    <div class="glass-card p-8 rounded-3xl">
        <h3 class="text-xs font-black text-slate-400 uppercase tracking-[3px] mb-6">Quick Actions</h3>
        <div class="space-y-3">
            <button onclick="document.getElementById('incomeModal').classList.remove('hidden')" 
                class="w-full h-14 bg-white/5 hover:bg-white/10 border border-white/5 rounded-2xl flex items-center px-6 transition-all group">
                <i data-lucide="plus-circle" class="w-5 h-5 text-indigo-400 group-hover:scale-110 transition-transform"></i>
                <span class="ml-4 text-sm font-bold">Add Income Entry</span>
            </button>
            <a href="<?php echo url('User/support.php'); ?>" 
                class="w-full h-14 bg-white/5 hover:bg-white/10 border border-white/5 rounded-2xl flex items-center px-6 transition-all group">
                <i data-lucide="life-buoy" class="w-5 h-5 text-purple-400 group-hover:rotate-12 transition-transform"></i>
                <span class="ml-4 text-sm font-bold">Open Support Ticket</span>
            </a>
        </div>
    </div>
</div>

<!-- Performance Telemetry -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <div class="glass-card p-6 rounded-[2rem] border-white/5">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 bg-emerald-500/10 text-emerald-400 rounded-lg flex items-center justify-center">
                <i data-lucide="zap" class="w-4 h-4"></i>
            </div>
            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Daily Velocity</span>
        </div>
        <div class="text-2xl font-black text-slate-100" data-stat="daily_total"><?php echo format_currency($stats['daily_total']); ?></div>
        <div class="mt-2 text-[9px] font-bold text-slate-600 uppercase">Today's contributions</div>
    </div>

    <div class="glass-card p-6 rounded-[2rem] border-white/5">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 bg-indigo-500/10 text-indigo-400 rounded-lg flex items-center justify-center">
                <i data-lucide="calendar" class="w-4 h-4"></i>
            </div>
            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Monthly Pulse</span>
        </div>
        <div class="text-2xl font-black text-slate-100"><?php echo format_currency($stats['monthly_total']); ?></div>
        <div class="mt-2 text-[9px] font-bold text-slate-600 uppercase">Current cycle total</div>
    </div>

    <div class="glass-card p-6 rounded-[2rem] border-white/5">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-8 h-8 bg-purple-500/10 text-purple-400 rounded-lg flex items-center justify-center">
                <i data-lucide="trending-up" class="w-4 h-4"></i>
            </div>
            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Yearly Output</span>
        </div>
        <div class="text-2xl font-black text-slate-100"><?php echo format_currency($stats['yearly_total']); ?></div>
        <div class="mt-2 text-[9px] font-bold text-slate-600 uppercase">Fiscal year accumulation</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- History Table (Minimal) -->
    <div class="glass-card rounded-3xl overflow-hidden">
        <div class="p-8 border-b border-white/5 flex items-center justify-between">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[3px]">Recent History</h3>
            <a href="<?php echo url('User/history.php'); ?>" class="text-[10px] font-black text-indigo-400 uppercase tracking-widest hover:text-indigo-300 transition-colors">View All</a>
        </div>
        <div class="divide-y divide-white/5">
            <?php foreach ($stats['my_history'] as $item): ?>
            <div class="p-6 flex items-center justify-between hover:bg-white/[0.02] transition-colors group">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center text-slate-400 group-hover:text-white transition-colors">
                        <i data-lucide="file-text" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm"><?php echo e($item['source']); ?></p>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider"><?php echo date('M d, Y', strtotime($item['created_at'])); ?></p>
                    </div>
                </div>
                <p class="font-black text-slate-200"><?php echo format_currency($item['amount']); ?></p>
            </div>
            <?php endforeach; ?>
            <?php if (empty($stats['my_history'])): ?>
                <div class="p-12 text-center text-slate-500 text-sm italic font-medium">No recent activity detected.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Status Alerts -->
    <div class="glass-card p-8 rounded-3xl">
        <h3 class="text-xs font-black text-slate-400 uppercase tracking-[3px] mb-8">Ticket Monitor</h3>
        <div class="space-y-6">
            <?php foreach ($stats['pending_requests'] as $req): ?>
            <div class="relative pl-6 border-l-2 border-orange-500/50">
                <p class="text-sm font-bold text-slate-200 mb-2"><?php echo e(mb_strimwidth($req['message'], 0, 80, "...")); ?></p>
                <div class="flex items-center gap-4">
                    <span class="text-[10px] font-black uppercase text-orange-400">Processing</span>
                    <span class="text-[10px] text-slate-600 font-bold uppercase"><?php echo date('M d', strtotime($req['created_at'])); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if (empty($stats['pending_requests'])): ?>
                <div class="flex flex-col items-center justify-center py-10 opacity-50">
                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mb-4">
                        <i data-lucide="check" class="w-8 h-8 text-emerald-500"></i>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">System Clear</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="mt-8 pt-8 border-t border-white/5">
            <p class="text-[10px] text-slate-500 font-medium leading-relaxed italic">
                Support response time is currently optimized. You will receive an email notification once your request status is updated.
            </p>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
