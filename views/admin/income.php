<!-- views/admin/income.php -->
<?php 
$pageTitle = 'Capital Management';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
    <div>
        <h3 class="text-2xl font-black text-slate-100 mt-2">Revenue <span class="text-indigo-400">Registry</span></h3>
        <p class="text-slate-500 text-sm font-medium">Immutable audit logs and financial synchronization points.</p>
    </div>
    <button onclick="document.getElementById('incomeModal').classList.remove('hidden')" 
        class="h-14 px-8 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-600/30 flex items-center group">
        <i data-lucide="plus" class="w-5 h-5 mr-3 group-hover:rotate-90 transition-transform"></i>
        Register Income
    </button>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="bg-emerald-500/10 text-emerald-500 p-5 rounded-3xl border border-emerald-500/20 mb-10 flex items-center font-bold animate-fade-in">
        <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
        <?php echo e($_GET['success']); ?>
    </div>
<?php endif; ?>

<div class="glass-card rounded-3xl overflow-hidden border border-white/5 shadow-2xl shadow-black/50 overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead class="bg-white/5 border-b border-white/5">
            <tr>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Execution Date</th>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Source/Project</th>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Submited By</th>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px] text-right">Gross Amount</th>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px] text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            <?php foreach ($incomeList as $item): ?>
            <tr class="hover:bg-white/[0.02] transition-colors group">
                <td class="px-8 py-5 text-slate-500 font-mono text-xs">
                    <?php echo date('M d, Y', strtotime($item['created_at'])); ?>
                </td>
                <td class="px-8 py-5">
                    <div class="font-bold text-slate-200"><?php echo e($item['source']); ?></div>
                    <div class="text-[9px] text-slate-600 font-black uppercase tracking-wider mt-1">Ref ID: #<?php echo $item['id']; ?></div>
                </td>
                <td class="px-8 py-5">
                    <div class="flex items-center gap-3">
                         <div class="w-8 h-8 rounded-full bg-indigo-500/10 flex items-center justify-center text-[10px] font-black text-indigo-400 border border-indigo-500/20">
                            <?php echo strtoupper(substr($item['user_name'], 0, 1)); ?>
                        </div>
                        <span class="text-sm font-bold text-slate-300"><?php echo e($item['user_name']); ?></span>
                    </div>
                </td>
                <td class="px-8 py-5 text-right font-black text-white text-lg">
                    <?php echo format_currency($item['amount']); ?>
                </td>
                <td class="px-8 py-5">
                    <div class="flex items-center justify-end gap-2">
                        <button onclick='editIncome(<?php echo json_encode($item, JSON_HEX_APOS | JSON_HEX_QUOT); ?>)' 
                            class="p-2.5 text-slate-400 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-xl transition-all">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </button>
                        <form method="POST" action="<?php echo url('Admin/income.php?action=delete'); ?>" onsubmit="return confirm('Archive this record? This affects global revenue totals.')" class="inline">
                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <button type="submit" class="p-2.5 text-slate-400 hover:text-red-500 hover:bg-red-500/10 rounded-xl transition-all">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal is handled locally to prevent collision with Global Quick Add -->
<div id="editModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-xl z-[100] flex items-center justify-center hidden p-4">
    <div class="glass-card shadow-[0_20px_50px_rgba(0,0,0,0.5)] border-white/10 w-full max-w-lg p-10 lg:p-14 rounded-[40px] animate-fade-in relative">
        <button onclick="document.getElementById('editModal').classList.add('hidden')" class="absolute top-8 right-8 text-slate-500 hover:text-white transition-colors">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>

        <div class="w-16 h-16 bg-indigo-500/10 text-indigo-400 rounded-2xl flex items-center justify-center mb-8">
            <i data-lucide="edit-3" class="w-8 h-8"></i>
        </div>
        <h3 class="text-3xl font-black tracking-tight text-white mb-2">Audit Record</h3>
        <p class="text-slate-500 text-sm font-medium mb-10">Sync real-time transitions into the financial ledger.</p>
        
        <form method="POST" action="<?php echo url('Admin/income.php?action=edit'); ?>" id="editForm" class="space-y-6 text-left">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="id" id="editIncomeId">
            
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[3px] ml-1">Gross Amount (USD)</label>
                <div class="relative">
                    <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-500 font-bold">$</span>
                    <input type="number" step="0.01" name="amount" id="incomeAmount" required 
                        class="w-full bg-slate-950 border border-white/5 rounded-3xl py-4 pl-10 pr-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all text-white font-black text-2xl">
                </div>
            </div>
            
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[3px] ml-1">Revenue Source</label>
                <input type="text" name="source" id="incomeSource" required 
                    class="w-full bg-slate-950 border border-white/5 rounded-3xl py-4 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all text-slate-200 font-bold"
                    placeholder="e.g. Project 'X' - Bounty">
            </div>
            
            <button type="submit" class="w-full h-16 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-3xl transition-all shadow-xl shadow-indigo-600/30">
                Commit Entry
            </button>
        </form>
    </div>
</div>

<script>
function editIncome(item) {
    document.getElementById('editIncomeId').value = item.id;
    document.getElementById('incomeAmount').value = item.amount;
    document.getElementById('incomeSource').value = item.source;
    document.getElementById('editModal').classList.remove('hidden');
}

lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
