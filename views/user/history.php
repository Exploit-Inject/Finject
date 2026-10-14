<!-- views/user/history.php -->
<?php 
$pageTitle = 'Transaction History';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
    <div>
        <h3 class="text-2xl font-black text-slate-100 mt-2">Active <span class="text-indigo-400">Contributions</span></h3>
        <p class="text-slate-500 text-sm font-medium">Historical audit of all records you have submitted to the organization.</p>
    </div>
    <button onclick="document.getElementById('incomeModal').classList.remove('hidden')" 
        class="h-14 px-8 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-600/30 flex items-center group">
        <i data-lucide="plus" class="w-5 h-5 mr-3 group-hover:rotate-90 transition-transform"></i>
        Register Income
    </button>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="bg-emerald-500/10 text-emerald-500 p-4 rounded-2xl border border-emerald-500/20 mb-8 flex items-center text-sm font-bold animate-fade-in">
        <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
        <?php echo e($_GET['success']); ?>
    </div>
<?php endif; ?>

<div class="glass-card rounded-3xl overflow-hidden border border-white/5 shadow-2xl shadow-black/50 overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead class="bg-white/5 border-b border-white/5">
            <tr>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Execution Date</th>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Revenue Source</th>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Gross Amount</th>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px] text-right">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            <?php foreach ($history as $item): ?>
            <tr class="hover:bg-white/[0.02] transition-colors group">
                <td class="px-8 py-5 text-slate-500 font-mono text-xs">
                    <?php echo date('M d, Y', strtotime($item['created_at'])); ?>
                </td>
                <td class="px-8 py-5">
                    <div class="font-bold text-slate-200"><?php echo e($item['source']); ?></div>
                    <div class="text-[9px] text-slate-600 font-black uppercase tracking-wider mt-1">Transaction ID: #<?php echo $item['id']; ?></div>
                </td>
                <td class="px-8 py-5 font-black text-white text-lg"><?php echo format_currency($item['amount']); ?></td>
                <td class="px-8 py-5 text-right">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-black rounded-full uppercase tracking-widest">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                        Immutable
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($history)): ?>
            <tr>
                <td colspan="4" class="px-8 py-16 text-center text-slate-500 font-medium italic opacity-50">Zero historical records found for this identity.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
