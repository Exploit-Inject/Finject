<!-- views/user/support.php -->
<?php 
$pageTitle = 'Center of Support';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-10 animate-fade-in">
    <!-- Submit Request -->
    <div class="lg:col-span-1">
        <div class="glass-card p-10 rounded-[40px] border border-white/5 sticky top-28 shadow-2xl shadow-indigo-500/5">
            <div class="w-14 h-14 bg-indigo-500/10 text-indigo-400 rounded-2xl flex items-center justify-center mb-8">
                <i data-lucide="help-circle" class="w-7 h-7"></i>
            </div>
            <h3 class="text-2xl font-black text-white tracking-tight mb-2">New Inquiry</h3>
            <p class="text-slate-500 text-sm font-medium mb-10">Request platform support or clarify distribution records.</p>
            
            <?php if (isset($_GET['success'])): ?>
                <div class="bg-emerald-500/10 text-emerald-500 p-4 rounded-2xl border border-emerald-500/20 mb-8 text-sm flex items-center font-bold">
                    <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
                    <?php echo e($_GET['success']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo url('User/support.php'); ?>" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[3px] ml-1 mb-2">Detailed Log</label>
                    <textarea name="message" required rows="6" 
                        class="w-full bg-slate-950 border border-white/5 rounded-3xl py-4 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all text-slate-200 font-medium resize-none"
                        placeholder="Provide details for the administration team..."></textarea>
                </div>
                <button type="submit" 
                    class="w-full h-14 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-600/30 flex items-center justify-center gap-3">
                    <span>Send Transmission</span>
                    <i data-lucide="send" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- My Requests -->
    <div class="lg:col-span-2">
        <div class="glass-card rounded-[40px] border border-white/5 shadow-2xl shadow-black/50 overflow-hidden">
            <div class="p-8 border-b border-white/5 bg-white/[0.02]">
                <h3 class="font-black text-white text-sm uppercase tracking-[3px]">Inquiry History</h3>
            </div>
            <div class="divide-y divide-white/5 font-medium" data-realtime-container="support-list">
                <?php foreach ($requests as $req): ?>
                <div class="p-10 hover:bg-white/[0.01] transition-colors">
                    <div class="flex flex-wrap justify-between items-start gap-4 mb-6">
                        <div class="flex items-center gap-4">
                            <i data-lucide="ticket" class="w-5 h-5 text-slate-600"></i>
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                #<?php echo $req['id']; ?> • <?php echo date('M d, Y', strtotime($req['created_at'])); ?>
                            </span>
                        </div>
                        <?php 
                        $statusClass = $req['status'] === 'pending' ? 'bg-orange-500/10 text-orange-400 border-orange-500/20' : 
                                      ($req['status'] === 'resolved' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-red-500/10 text-red-400 border-red-500/20');
                        ?>
                        <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border <?php echo $statusClass; ?>">
                            <?php echo e($req['status']); ?>
                        </span>
                    </div>
                    <p class="text-slate-300 leading-relaxed text-sm mb-8"><?php echo e($req['message']); ?></p>
                    
                    <?php if ($req['admin_notes']): ?>
                    <div class="bg-indigo-500/5 p-6 rounded-3xl border border-indigo-500/10 relative">
                        <div class="absolute top-0 right-0 p-4 opacity-5">
                            <i data-lucide="message-square" class="w-12 h-12 text-indigo-400"></i>
                        </div>
                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-3">Admin Response Override</p>
                        <p class="text-sm text-indigo-200/80 italic leading-relaxed"><?php echo e($req['admin_notes']); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                
                <?php if (empty($requests)): ?>
                <div class="p-20 text-center opacity-40">
                    <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-4 text-slate-600"></i>
                    <p class="text-xs font-black uppercase tracking-widest text-slate-500">Zero Inquiries Recorded</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
