<!-- views/admin/users.php -->
<?php 
$pageTitle = 'Team Management';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="flex justify-between items-center mb-10 animate-fade-in">
    <div>
        <h3 class="text-2xl font-black text-slate-100 mt-2">Team <span class="text-indigo-400">Members</span></h3>
        <p class="text-slate-500 text-sm font-medium">Add, edit or remove users from the platform</p>
    </div>
    <button onclick="document.getElementById('userModal').classList.remove('hidden')" 
        class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-full font-bold transition-all flex items-center shadow-lg shadow-indigo-600/20">
        <i data-lucide="user-plus" class="w-5 h-5 mr-3"></i>
        Add New User
    </button>
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
                    <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">ID</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Member Details</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Contact Info</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px]">Platform Role</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[2px] text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                <?php foreach ($users as $user): ?>
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="px-8 py-5 text-slate-600 font-mono text-xs">#<?php echo $user['id']; ?></td>
                    <td class="px-8 py-5">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-indigo-500/10 text-indigo-400 rounded-xl flex items-center justify-center font-bold text-sm mr-4 border border-indigo-500/10 group-hover:bg-indigo-500 group-hover:text-white transition-all">
                                <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                            </div>
                            <div>
                                <div class="font-bold text-slate-200"><?php echo e($user['full_name'] ?: $user['name']); ?></div>
                                <div class="text-[10px] text-slate-500 font-bold uppercase tracking-wider"><?php echo e($user['email']); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-xs">
                        <div class="text-slate-400">WA: <?php echo e($user['whatsapp_number']); ?></div>
                        <div class="text-slate-500">Ph: <?php echo e($user['phone_number']); ?></div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest 
                            <?php 
                                switch($user['role']) {
                                    case 'admin': echo 'bg-purple-500/10 text-purple-400 border border-purple-500/20'; break;
                                    case 'lead_hunter': echo 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20'; break;
                                    case 'client_handler': echo 'bg-amber-500/10 text-amber-400 border border-amber-500/20'; break;
                                    case 'executioner': echo 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20'; break;
                                    default: echo 'bg-slate-500/10 text-slate-400 border border-slate-500/10';
                                }
                            ?>">
                            <?php echo e(str_replace('_', ' ', $user['role'])); ?>
                        </span>
                     </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex justify-end gap-2 opacity-40 group-hover:opacity-100 transition-opacity">
                            <button onclick='editUser(<?php echo json_encode($user, JSON_HEX_APOS | JSON_HEX_QUOT); ?>)' class="p-2 text-slate-400 hover:text-indigo-400 transition-colors">
                                <i data-lucide="edit-3" class="w-5 h-5"></i>
                            </button>
                            <form method="POST" action="<?php echo url('Admin/users.php?action=delete'); ?>" onsubmit="return confirm('Archive this user? This cannot be undone.')">
                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Dynamic Modal -->
<div id="userModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-xl z-[100] flex items-center justify-center hidden p-4">
    <div class="glass-card shadow-[0_20px_50px_rgba(0,0,0,0.5)] border-white/10 w-full max-w-2xl p-10 lg:p-12 rounded-[40px] animate-fade-in max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-10">
            <h3 id="modalTitle" class="text-2xl font-black tracking-tight text-white">Add Team Member</h3>
            <button onclick="document.getElementById('userModal').classList.add('hidden')" class="text-slate-500 hover:text-white transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <form method="POST" action="<?php echo url('Admin/users.php?action=add'); ?>" id="userForm" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="id" id="userId">
            
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[2px] ml-1">Username</label>
                <input type="text" name="name" id="userName" required class="w-full bg-slate-950 border border-white/5 rounded-2xl py-3.5 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all font-medium text-slate-200">
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[2px] ml-1">Full Name</label>
                <input type="text" name="full_name" id="userFullName" required class="w-full bg-slate-950 border border-white/5 rounded-2xl py-3.5 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all font-medium text-slate-200">
            </div>
            
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[2px] ml-1">Login Email</label>
                <input type="email" name="email" id="userEmail" required class="w-full bg-slate-950 border border-white/5 rounded-2xl py-3.5 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all font-medium text-slate-200">
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[2px] ml-1">Personal Email</label>
                <input type="email" name="personal_email" id="userPersonalEmail" required class="w-full bg-slate-950 border border-white/5 rounded-2xl py-3.5 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all font-medium text-slate-200">
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[2px] ml-1">WhatsApp</label>
                <input type="text" name="whatsapp_number" id="userWhatsApp" required class="w-full bg-slate-950 border border-white/5 rounded-2xl py-3.5 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all font-medium text-slate-200">
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[2px] ml-1">Phone</label>
                <input type="text" name="phone_number" id="userPhone" required class="w-full bg-slate-950 border border-white/5 rounded-2xl py-3.5 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all font-medium text-slate-200">
            </div>
            
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[2px] ml-1">Password</label>
                <input type="password" name="password" id="userPassword" class="w-full bg-slate-950 border border-white/5 rounded-2xl py-3.5 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all font-medium text-slate-200" placeholder="••••••••">
            </div>
            
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[2px] ml-1">Assigned Role</label>
                <select name="role" id="userRole" class="w-full bg-slate-950 border border-white/5 rounded-2xl py-3.5 px-6 outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/5 transition-all font-medium text-slate-200 appearance-none">
                    <option value="lead_hunter">Lead Hunter</option>
                    <option value="client_handler">Client Handler (Account Manager)</option>
                    <option value="executioner">Executioner (Website Builder)</option>
                    <option value="admin">Platform Admin</option>
                </select>
            </div>
            
            <div class="md:col-span-2">
                <button type="submit" class="w-full h-14 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-600/30 mt-4">
                    Confirm Membership Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function editUser(user) {
    document.getElementById('modalTitle').innerText = 'Update Member Record';
    document.getElementById('userForm').action = '<?php echo url("Admin/users.php?action=edit"); ?>';
    document.getElementById('userId').value = user.id;
    document.getElementById('userName').value = user.name;
    document.getElementById('userFullName').value = user.full_name;
    document.getElementById('userEmail').value = user.email;
    document.getElementById('userPersonalEmail').value = user.personal_email;
    document.getElementById('userWhatsApp').value = user.whatsapp_number;
    document.getElementById('userPhone').value = user.phone_number;
    document.getElementById('userRole').value = user.role;
    document.getElementById('userPassword').placeholder = 'Leave blank to preserve current';
    document.getElementById('userModal').classList.remove('hidden');
}

lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
