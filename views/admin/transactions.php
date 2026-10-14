<!-- views/admin/transactions.php -->
<?php 
$pageTitle = 'Intelligence Reports';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in">
    <div>
        <h3 class="text-2xl font-black text-slate-100 mt-2">Financial <span class="text-indigo-400">Intelligence</span></h3>
        <p class="text-slate-500 text-sm font-medium">Advanced filtering and detailed distribution auditing.</p>
    </div>
    <button onclick="exportCSV()" class="h-12 px-8 bg-white/5 border border-white/5 text-slate-200 rounded-full font-bold hover:bg-white/10 transition-all flex items-center shadow-sm">
        <i data-lucide="download" class="w-4 h-4 mr-2 text-indigo-400"></i>
        Export Dataset (.CSV)
    </button>
</div>

<!-- Filters -->
<div class="glass-card p-8 rounded-3xl border border-white/5 mb-10">
    <form method="GET" action="<?php echo url('Admin/transactions.php'); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-6">
        
        <div class="space-y-2">
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[2px] ml-1">Member Filter</label>
            <div class="relative">
                <i data-lucide="users" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-indigo-400/50"></i>
                <select name="user_id" class="w-full bg-slate-950 border border-white/5 rounded-2xl py-3 pl-12 pr-6 outline-none focus:border-indigo-500/50 transition-all font-medium text-slate-200 appearance-none">
                    <option value="">All Personnel</option>
                    <?php foreach ($users as $u): ?>
                        <option value="<?php echo $u['id']; ?>" <?php echo ($filters['user_id'] == $u['id']) ? 'selected' : ''; ?>>
                            <?php echo e($u['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="space-y-2">
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[2px] ml-1">Period Start</label>
            <input type="date" name="start_date" value="<?php echo e($filters['start_date']); ?>"
                class="w-full bg-slate-950 border border-white/5 rounded-2xl py-3 px-6 outline-none focus:border-indigo-500/50 transition-all font-medium text-slate-200">
        </div>

        <div class="space-y-2">
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[2px] ml-1">Period End</label>
            <input type="date" name="end_date" value="<?php echo e($filters['end_date']); ?>"
                class="w-full bg-slate-950 border border-white/5 rounded-2xl py-3 px-6 outline-none focus:border-indigo-500/50 transition-all font-medium text-slate-200">
        </div>

        <div class="flex items-end pb-1">
            <button type="submit" class="w-full h-12 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl transition-all shadow-lg shadow-indigo-600/20">
                Apply Intelligence Filter
            </button>
        </div>
    </form>
</div>

<div class="glass-card rounded-3xl overflow-hidden border border-white/5 shadow-2xl shadow-black/50 overflow-x-auto">
    <table id="transactionTable" class="w-full text-left border-collapse">
        <thead class="bg-white/5 border-b border-white/5">
            <tr>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">ID</th>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Date</th>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Source Project</th>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px] text-right">Gross Total</th>
                <th class="px-8 py-5 text-[10px] font-black text-indigo-400 uppercase tracking-[2px] text-right">Startup</th>
                <th class="px-8 py-5 text-[10px] font-black text-purple-400 uppercase tracking-[2px] text-right">Member Pool</th>
                <th class="px-8 py-5 text-[10px] font-black text-orange-400 uppercase tracking-[2px] text-right">Exec</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            <?php foreach ($transactions as $t): ?>
            <tr class="hover:bg-white/[0.02] transition-colors group">
                <td class="px-8 py-5 text-slate-600 font-mono text-[10px]">#<?php echo $t['id']; ?></td>
                <td class="px-8 py-5 text-slate-500 font-bold text-xs uppercase"><?php echo date('Y-m-d', strtotime($t['created_at'])); ?></td>
                <td class="px-8 py-5 font-black text-slate-200"><?php echo e($t['source']); ?></td>
                <td class="px-8 py-5 text-right font-black text-white"><?php echo format_currency($t['amount']); ?></td>
                <td class="px-8 py-5 text-right text-indigo-400 font-bold text-xs"><?php echo format_currency($t['startup_amount']); ?></td>
                <td class="px-8 py-5 text-right text-purple-400 font-bold text-xs"><?php echo format_currency($t['member_amount']); ?></td>
                <td class="px-8 py-5 text-right text-orange-400 font-bold text-xs"><?php echo format_currency($t['execution_amount']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function exportCSV() {
    let csv = [];
    const rows = document.querySelectorAll("#transactionTable tr");
    
    for (const row of rows) {
        const cols = row.querySelectorAll("td, th");
        const rowData = [];
        for (const col of cols) {
            rowData.push('"' + col.innerText.replace(/"/g, '""') + '"');
        }
        csv.push(rowData.join(","));
    }
    
    const csvString = csv.join("\n");
    const blob = new Blob([csvString], { type: "text/csv" });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.setAttribute("href", url);
    a.setAttribute("download", "FINJECT_REPORT_" + new Date().toISOString().split('T')[0] + ".csv");
    a.click();
}

lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
