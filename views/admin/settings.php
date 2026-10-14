<!-- views/admin/settings.php -->
<?php 
$pageTitle = 'Protocol Settings';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="max-w-3xl mx-auto animate-fade-in">
    <div class="glass-card rounded-[40px] border border-white/5 overflow-hidden shadow-2xl shadow-indigo-500/5">
        <div class="p-10 lg:p-12 border-b border-white/5 bg-white/[0.02]">
            <div class="w-16 h-16 bg-indigo-500/10 text-indigo-400 rounded-3xl flex items-center justify-center mb-6">
                <i data-lucide="sliders" class="w-8 h-8"></i>
            </div>
            <h3 class="text-3xl font-black text-white tracking-tight">Distribution Protocol</h3>
            <p class="text-slate-500 mt-2 font-medium">Fine-tune the organization revenue splitting logic. Total must strictly equal 100%.</p>
        </div>

        <div class="p-10 lg:p-12">
            <?php if (isset($_GET['success'])): ?>
                <div class="bg-emerald-500/10 text-emerald-500 p-5 rounded-2xl border border-emerald-500/20 mb-10 flex items-center font-bold">
                    <i data-lucide="check" class="w-5 h-5 mr-3"></i>
                    <?php echo e($_GET['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="bg-red-500/10 text-red-500 p-5 rounded-2xl border border-red-500/20 mb-10 font-bold">
                    <?php echo e($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo url('Admin/settings.php'); ?>" class="space-y-10">
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[3px] ml-1">Startup (%)</label>
                        <input type="number" name="startup_pct" id="startup_pct" required min="0" max="100"
                            value="<?php echo $settings['startup_pct']; ?>"
                            class="w-full bg-slate-900 border border-white/5 rounded-2xl py-5 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all text-center text-2xl font-black text-indigo-400">
                    </div>
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[3px] ml-1">Members (%)</label>
                        <input type="number" name="member_pct" id="member_pct" required min="0" max="100"
                            value="<?php echo $settings['member_pct']; ?>"
                            class="w-full bg-slate-900 border border-white/5 rounded-2xl py-5 px-6 outline-none focus:border-purple-500/50 focus:ring-4 focus:ring-purple-500/5 transition-all text-center text-2xl font-black text-purple-400">
                    </div>
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[3px] ml-1">Execution (%)</label>
                        <input type="number" name="execution_pct" id="execution_pct" required min="0" max="100"
                            value="<?php echo $settings['execution_pct']; ?>"
                            class="w-full bg-slate-900 border border-white/5 rounded-2xl py-5 px-6 outline-none focus:border-orange-500/50 focus:ring-4 focus:ring-orange-500/5 transition-all text-center text-2xl font-black text-orange-400">
                    </div>
                </div>

                <div class="bg-slate-950 p-8 rounded-3xl flex items-center justify-between border border-white/5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-[0.03]">
                        <i data-lucide="percent" class="w-20 h-20 text-white"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-[3px]">Consolidated Checksum</span>
                        <div id="totalSpan" class="text-4xl font-black text-white mt-1 transition-all duration-300">0%</div>
                    </div>
                    <div id="statusIcon" class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300">
                        <i data-lucide="activity" class="w-6 h-6"></i>
                    </div>
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full h-16 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-600/30">
                    Propagate Distribution Protocol
                </button>
            </form>
        </div>
    </div>

    <div class="mt-12 bg-indigo-500/5 p-8 rounded-3xl border border-indigo-500/10 flex gap-6 items-start">
        <div class="text-indigo-400 mt-1">
            <i data-lucide="info" class="w-6 h-6"></i>
        </div>
        <div class="text-xs font-bold text-slate-400 leading-relaxed uppercase tracking-wider">
            Critical Security Policy: Modification of these parameters will strictly affect future ledger entries. Historical transactions remain anchored to their original distribution ratios to maintain accounting integrity.
        </div>
    </div>
</div>

<script>
const inputs = ['startup_pct', 'member_pct', 'execution_pct'];
function updateTotal() {
    let total = 0;
    inputs.forEach(id => {
        total += parseInt(document.getElementById(id).value) || 0;
    });
    const span = document.getElementById('totalSpan');
    const statusIcon = document.getElementById('statusIcon');
    const submitBtn = document.getElementById('submitBtn');
    
    span.innerText = total + '%';
    
    if (total === 100) {
        span.className = 'text-4xl font-black text-emerald-400 mt-1';
        statusIcon.className = 'w-12 h-12 bg-emerald-500/10 text-emerald-500 rounded-full flex items-center justify-center shadow-lg shadow-emerald-500/10';
        submitBtn.disabled = false;
        submitBtn.className = 'w-full h-16 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-600/30';
    } else {
        span.className = 'text-4xl font-black text-red-500 mt-1';
        statusIcon.className = 'w-12 h-12 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center shadow-lg shadow-red-500/10';
        submitBtn.disabled = true;
        submitBtn.className = 'w-full h-16 bg-slate-800 cursor-not-allowed text-slate-500 font-black rounded-2xl transition-all';
    }
}

inputs.forEach(id => {
    document.getElementById(id).addEventListener('input', updateTotal);
});

lucide.createIcons();
updateTotal();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
