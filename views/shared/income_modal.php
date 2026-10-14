<!-- views/shared/income_modal.php -->
<div id="incomeModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-xl z-[100] flex items-center justify-center hidden p-4">
    <div class="glass-card shadow-[0_20px_50px_rgba(0,0,0,0.5)] border-white/10 w-full max-w-lg p-10 lg:p-14 rounded-[40px] animate-fade-in relative">
        <button onclick="document.getElementById('incomeModal').classList.add('hidden')" class="absolute top-8 right-8 text-slate-500 hover:text-white transition-colors">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>

        <div class="w-16 h-16 bg-indigo-500/10 text-indigo-400 rounded-2xl flex items-center justify-center mb-8">
            <i data-lucide="wallet" class="w-8 h-8"></i>
        </div>
        <h3 class="text-3xl font-black tracking-tight text-white mb-2">Record Capital</h3>
        <p class="text-slate-500 text-sm font-medium mb-10">Add new income to the organization's registry.</p>
        
        <form method="POST" action="<?php echo url('user/add-income.php'); ?>" class="space-y-6 text-left">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[3px] ml-1">Gross Amount (USD)</label>
                <div class="relative">
                    <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-500 font-bold">$</span>
                    <input type="number" step="0.01" name="amount" required 
                        class="w-full bg-slate-950 border border-white/5 rounded-3xl py-4 pl-10 pr-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all text-white font-black text-2xl">
                </div>
            </div>
            
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[3px] ml-1">Revenue Source</label>
                <input type="text" name="source" required 
                    class="w-full bg-slate-950 border border-white/5 rounded-3xl py-4 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all text-slate-200 font-bold"
                    placeholder="e.g. Project 'X' - Bounty">
            </div>
            
            <button type="submit" class="w-full h-16 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-3xl transition-all shadow-xl shadow-indigo-600/30">
                Commit Entry
            </button>
        </form>
    </div>
</div>
