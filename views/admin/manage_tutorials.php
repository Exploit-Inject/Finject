<!-- views/admin/manage_tutorials.php -->
<?php 
$pageTitle = 'Manage Academy Tutorials';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="flex justify-between items-center mb-10 animate-fade-in">
    <div>
        <h3 class="text-2xl font-black text-slate-100 mt-2">Finject <span class="text-indigo-400">Academy</span></h3>
        <p class="text-slate-500 text-sm font-medium">Upload training materials, videos, and guides</p>
    </div>
    <button onclick="document.getElementById('tutorialModal').classList.remove('hidden')" 
        class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-full font-bold transition-all flex items-center shadow-lg shadow-indigo-600/20">
        <i data-lucide="video" class="w-5 h-5 mr-3"></i>
        Add New Tutorial
    </button>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="bg-emerald-500/10 text-emerald-500 p-4 rounded-2xl border border-emerald-500/20 mb-8 flex items-center text-sm font-bold animate-fade-in">
        <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
        <?php echo e($_GET['success']); ?>
    </div>
<?php endif; ?>

<div class="glass-card rounded-[32px] overflow-hidden border border-white/5">
    <table class="w-full text-left border-collapse">
        <thead class="bg-white/5 border-b border-white/5">
            <tr>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Tutorial</th>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Type</th>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Created At</th>
                <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px] text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            <?php foreach ($tutorials as $tut): ?>
            <tr class="hover:bg-white/[0.02] transition-colors group">
                <td class="px-8 py-5">
                    <div class="font-bold text-slate-200"><?php echo e($tut['title']); ?></div>
                    <div class="text-[10px] text-slate-500 font-bold truncate max-w-xs"><?php echo e($tut['description']); ?></div>
                </td>
                <td class="px-8 py-5">
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-slate-900 text-slate-400 border border-white/5">
                        <?php echo e($tut['media_type']); ?>
                    </span>
                </td>
                <td class="px-8 py-5 text-slate-500 text-xs font-medium">
                    <?php echo date('M d, Y', strtotime($tut['created_at'])); ?>
                </td>
                <td class="px-8 py-5 text-right">
                    <form method="POST" action="<?php echo url('Admin/manage-tutorials.php?action=delete'); ?>" onsubmit="return confirm('Delete this tutorial?')">
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="id" value="<?php echo $tut['id']; ?>">
                        <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="tutorialModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-xl z-[100] flex items-center justify-center hidden p-4">
    <div class="glass-card shadow-2xl border-white/10 w-full max-w-2xl p-10 lg:p-12 rounded-[40px] animate-fade-in max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-2xl font-black text-white">Upload New Tutorial</h3>
            <button onclick="document.getElementById('tutorialModal').classList.add('hidden')" class="text-slate-500 hover:text-white transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <form method="POST" action="<?php echo url('Admin/manage-tutorials.php?action=add'); ?>" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            
            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Title</label>
                <input type="text" name="title" required class="w-full bg-slate-950 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 transition-all font-medium text-slate-200">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Description</label>
                <textarea name="description" rows="2" class="w-full bg-slate-950 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 transition-all font-medium text-slate-200"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Media Type</label>
                    <select name="media_type" class="w-full bg-slate-950 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 transition-all font-medium text-slate-200 appearance-none">
                        <option value="video">Video</option>
                        <option value="audio">Audio</option>
                        <option value="text">Text/Article</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Media URL</label>
                    <input type="text" name="media_url" class="w-full bg-slate-950 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 transition-all font-medium text-slate-200" placeholder="Youtube/Drive/Audio link">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Article Content (if Text type)</label>
                <textarea name="content_text" rows="5" class="w-full bg-slate-950 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 transition-all font-medium text-slate-200"></textarea>
            </div>
            
            <button type="submit" class="w-full h-14 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-600/30 mt-4">
                Publish Tutorial
            </button>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
