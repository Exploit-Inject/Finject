<!-- views/admin/manage_clients_data.php -->
<?php 
$pageTitle = 'Manage Client Data Buttons';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="flex justify-between items-center mb-10 animate-fade-in">
    <div>
        <h3 class="text-2xl font-black text-slate-100 mt-2">Client Data <span class="text-indigo-400">Hub</span></h3>
        <p class="text-slate-500 text-sm font-medium">Manage dynamic buttons and links for the team</p>
    </div>
    <button onclick="document.getElementById('buttonModal').classList.remove('hidden')" 
        class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-full font-bold transition-all flex items-center shadow-lg shadow-indigo-600/20">
        <i data-lucide="plus-circle" class="w-5 h-5 mr-3"></i>
        Add New Button
    </button>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="bg-emerald-500/10 text-emerald-500 p-4 rounded-2xl border border-emerald-500/20 mb-8 flex items-center text-sm font-bold animate-fade-in">
        <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
        <?php echo e($_GET['success']); ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
    <?php foreach ($buttons as $btn): ?>
        <div class="glass-card p-6 rounded-[24px] border border-white/5 flex justify-between items-center group">
            <div>
                <h4 class="font-bold text-slate-200"><?php echo e($btn['label']); ?></h4>
                <p class="text-[10px] text-slate-500 font-mono truncate max-w-[200px]"><?php echo e($btn['url']); ?></p>
            </div>
            <form method="POST" action="<?php echo url('Admin/manage-clients-data.php?action=delete'); ?>" onsubmit="return confirm('Delete this button?')">
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="id" value="<?php echo $btn['id']; ?>">
                <button type="submit" class="p-2 text-slate-500 hover:text-red-500 transition-colors">
                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                </button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<!-- Add Modal -->
<div id="buttonModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-xl z-[100] flex items-center justify-center hidden p-4">
    <div class="glass-card shadow-2xl border-white/10 w-full max-w-lg p-10 rounded-[40px] animate-fade-in">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-2xl font-black text-white">Create New Link</h3>
            <button onclick="document.getElementById('buttonModal').classList.add('hidden')" class="text-slate-500 hover:text-white transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <form method="POST" action="<?php echo url('Admin/manage-clients-data.php?action=add'); ?>" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            
            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Button Label</label>
                <input type="text" name="label" required class="w-full bg-slate-950 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all font-medium text-slate-200" placeholder="e.g. Scraped Leads Dhaka">
            </div>
            
            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest pl-1">Destination URL</label>
                <input type="url" name="url" required class="w-full bg-slate-950 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all font-medium text-slate-200" placeholder="https://google.com/sheets/...">
            </div>
            
            <button type="submit" class="w-full h-14 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-600/30 mt-4">
                Deploy Button
            </button>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
