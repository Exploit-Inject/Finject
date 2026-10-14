<!-- views/admin/requests.php -->
<?php 
$pageTitle = 'Support Intelligence';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="mb-10 animate-fade-in">
    <h3 class="text-2xl font-black text-slate-100 mt-2">Team <span class="text-indigo-400">Inquiries</span></h3>
    <p class="text-slate-500 text-sm font-medium">Review and resolve member feedback and platform issues.</p>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="bg-emerald-500/10 text-emerald-500 p-4 rounded-2xl border border-emerald-500/20 mb-8 flex items-center text-sm font-bold animate-fade-in">
        <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
        <?php echo e($_GET['success']); ?>
    </div>
<?php endif; ?>

<div class="glass-card rounded-3xl overflow-hidden border border-white/5 shadow-2xl shadow-black/50">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-white/5 border-b border-white/5">
                <tr>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Requester</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Subject Snippet</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Current Status</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Received</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px] text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5" data-realtime-container="support-list">
                <?php foreach ($requests as $req): ?>
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="px-8 py-5">
                        <div class="font-bold text-slate-200"><?php echo e($req['user_name']); ?></div>
                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-wider"><?php echo e($req['user_email']); ?></div>
                    </td>
                    <td class="px-8 py-5 text-slate-400 text-sm max-w-xs truncate font-medium">
                        <?php echo e($req['message']); ?>
                    </td>
                    <td class="px-8 py-5">
                        <?php 
                        $statusClass = $req['status'] === 'pending' ? 'bg-orange-500/10 text-orange-400 border-orange-500/20' : 
                                      ($req['status'] === 'resolved' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-red-500/10 text-red-400 border-red-500/20');
                        ?>
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border <?php echo $statusClass; ?>">
                            <?php echo e($req['status']); ?>
                        </span>
                     </td>
                    <td class="px-8 py-5 text-slate-500 text-[10px] font-black uppercase tracking-wider">
                        <?php echo date('M d, Y', strtotime($req['created_at'])); ?>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <button onclick='openRequestModal(<?php echo json_encode($req, JSON_HEX_APOS | JSON_HEX_QUOT); ?>)' 
                            class="text-indigo-400 hover:text-indigo-300 font-black text-[10px] uppercase tracking-widest border border-indigo-400/20 px-4 py-2 rounded-lg transition-all hover:bg-indigo-400/10">
                            Audit Request
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Intelligence Modal -->
<div id="requestModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-xl z-[100] flex items-center justify-center hidden p-4">
    <div class="glass-card shadow-[0_20px_50px_rgba(0,0,0,0.5)] border-white/10 w-full max-w-2xl p-10 lg:p-14 rounded-[40px] animate-fade-in">
        <div class="flex justify-between items-center mb-10">
            <h3 class="text-2xl font-black tracking-tight text-white">Review Request</h3>
            <button onclick="document.getElementById('requestModal').classList.add('hidden')" class="text-slate-500 hover:text-white transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <div class="mb-10 p-8 bg-slate-900 border border-white/5 rounded-3xl relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-5">
                <i data-lucide="quote" class="w-16 h-16 text-indigo-400"></i>
            </div>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[3px] mb-4">Original Transmission</p>
            <p id="modalUserMessage" class="text-slate-200 leading-relaxed font-medium italic"></p>
        </div>

        <form method="POST" action="<?php echo url('Admin/requests.php'); ?>" class="space-y-8">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="id" id="requestId">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[2px] ml-1">Update Lifecycle Status</label>
                    <select name="status" id="modalStatus" class="w-full bg-slate-950 border border-white/5 rounded-2xl py-3.5 px-6 outline-none focus:border-indigo-500/50 transition-all font-bold text-indigo-200 appearance-none">
                        <option value="pending">Awaiting Action</option>
                        <option value="resolved">Mark Fixed / Resolved</option>
                        <option value="rejected">Decline / Archive</option>
                    </select>
                </div>
            </div>
            
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[2px] ml-1">Official Response / Logic</label>
                <textarea name="admin_notes" id="modalNotes" rows="5" 
                    class="w-full bg-slate-950 border border-white/5 rounded-2xl py-4 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all font-medium text-slate-200 resize-none"
                    placeholder="Provide detailed context for the resolution..."></textarea>
            </div>
            
            <div class="flex gap-4">
                 <button type="button" onclick="document.getElementById('requestModal').classList.add('hidden')" 
                    class="flex-1 h-14 bg-white/5 hover:bg-white/10 text-slate-400 font-black rounded-2xl transition-all">
                    Dismiss
                </button>
                <button type="submit" class="flex-[2] h-14 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-600/30">
                    Propagate Resolution
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRequestModal(req) {
    document.getElementById('requestId').value = req.id;
    document.getElementById('modalUserMessage').innerText = req.message;
    document.getElementById('modalStatus').value = req.status;
    document.getElementById('modalNotes').value = req.admin_notes || '';
    document.getElementById('requestModal').classList.remove('hidden');
}

lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
