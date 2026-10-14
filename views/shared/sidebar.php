<!-- views/shared/sidebar.php -->
<aside class="w-20 lg:w-64 bg-[#0A0F1C] border-r border-white/5 flex-shrink-0 flex flex-col hidden md:flex transition-all duration-300">
    <a href="<?php echo is_admin() ? url('Admin/dashboard.php') : url('User/dashboard.php'); ?>" class="h-20 flex items-center px-6 border-b border-white/5 group">
        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-600/30 group-hover:scale-110 transition-all">
            <i data-lucide="zap" class="text-white w-6 h-6 fill-current"></i>
        </div>
        <span class="ml-4 text-xl font-black tracking-tighter hidden lg:block text-glow group-hover:text-white transition-colors">FINJECT</span>
    </a>
    
    <nav class="flex-1 overflow-y-auto py-8">
        <div class="px-8 mb-6 text-[10px] font-black text-slate-600 uppercase tracking-[4px] hidden lg:block">Authorized Access</div>
        
        <div class="space-y-1">
            <?php if (is_admin()): ?>
                <a href="<?php echo url('Admin/dashboard.php'); ?>" class="sidebar-link <?php echo $route === 'admin/dashboard' ? 'active' : ''; ?>">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span class="ml-4 font-bold text-sm hidden lg:block">System Hub</span>
                </a>
                <a href="<?php echo url('Admin/users.php'); ?>" class="sidebar-link <?php echo $route === 'admin/users' ? 'active' : ''; ?>">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span class="ml-4 font-bold text-sm hidden lg:block">Team Protocol</span>
                </a>
                <a href="<?php echo url('Admin/income.php'); ?>" class="sidebar-link <?php echo $route === 'admin/income' ? 'active' : ''; ?>">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                    <span class="ml-4 font-bold text-sm hidden lg:block">Revenue Gate</span>
                </a>
                <a href="<?php echo url('Admin/transactions.php'); ?>" class="sidebar-link <?php echo $route === 'admin/transactions' ? 'active' : ''; ?>">
                    <i data-lucide="cpu" class="w-5 h-5"></i>
                    <span class="ml-4 font-bold text-sm hidden lg:block">Intel Nodes</span>
                </a>
                <a href="<?php echo url('Admin/requests.php'); ?>" class="sidebar-link <?php echo $route === 'admin/requests' ? 'active' : ''; ?>">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                    <span class="ml-4 font-bold text-sm hidden lg:block">Support Log</span>
                </a>
                <a href="<?php echo url('Admin/settings.php'); ?>" class="sidebar-link <?php echo $route === 'admin/settings' ? 'active' : ''; ?>">
                    <i data-lucide="shield" class="w-5 h-5"></i>
                    <span class="ml-4 font-bold text-sm hidden lg:block">Security Settings</span>
                </a>
                <div class="px-8 my-4 text-[10px] font-black text-slate-700 uppercase tracking-[4px] hidden lg:block">Intelligence Mgmt</div>
                <a href="<?php echo url('Admin/manage-clients-data.php'); ?>" class="sidebar-link <?php echo $route === 'admin/manage-clients-data' ? 'active' : ''; ?>">
                    <i data-lucide="database" class="w-5 h-5"></i>
                    <span class="ml-4 font-bold text-sm hidden lg:block">Clients Data</span>
                </a>
                <a href="<?php echo url('Admin/manage-tutorials.php'); ?>" class="sidebar-link <?php echo $route === 'admin/manage-tutorials' ? 'active' : ''; ?>">
                    <i data-lucide="video" class="w-5 h-5"></i>
                    <span class="ml-4 font-bold text-sm hidden lg:block">Academy Mgmt</span>
                </a>
            <?php else: ?>
                <a href="<?php echo url('User/dashboard.php'); ?>" class="sidebar-link <?php echo $route === 'user/dashboard' ? 'active' : ''; ?>">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span class="ml-4 font-bold text-sm hidden lg:block">Core Dashboard</span>
                </a>
                <a href="<?php echo url('User/clients.php'); ?>" class="sidebar-link <?php echo $route === 'user/clients' ? 'active' : ''; ?>">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span class="ml-4 font-bold text-sm hidden lg:block">Our Clients</span>
                </a>
                <a href="<?php echo url('User/tools.php'); ?>" class="sidebar-link <?php echo $route === 'user/tools' ? 'active' : ''; ?>">
                    <i data-lucide="briefcase" class="w-5 h-5"></i>
                    <span class="ml-4 font-bold text-sm hidden lg:block">Toolkit</span>
                </a>
                <a href="<?php echo url('User/clients-data.php'); ?>" class="sidebar-link <?php echo $route === 'user/clients-data' ? 'active' : ''; ?>">
                    <i data-lucide="database" class="w-5 h-5"></i>
                    <span class="ml-4 font-bold text-sm hidden lg:block">Clients Data</span>
                </a>
                <a href="<?php echo url('User/tutorials.php'); ?>" class="sidebar-link <?php echo $route === 'user/tutorials' ? 'active' : ''; ?>">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                    <span class="ml-4 font-bold text-sm hidden lg:block">Academy</span>
                </a>
                <a href="<?php echo url('User/history.php'); ?>" class="sidebar-link <?php echo $route === 'user/history' ? 'active' : ''; ?>">
                    <i data-lucide="terminal" class="w-5 h-5"></i>
                    <span class="ml-4 font-bold text-sm hidden lg:block">Flow Logs</span>
                </a>
                <a href="<?php echo url('User/support.php'); ?>" class="sidebar-link <?php echo $route === 'user/support' ? 'active' : ''; ?>">
                    <i data-lucide="headphones" class="w-5 h-5"></i>
                    <span class="ml-4 font-bold text-sm hidden lg:block">Secure Support</span>
                </a>
            <?php endif; ?>
        </div>
    </nav>
    
    <div class="p-6 border-t border-white/5 bg-[#080C14]">
        <a href="<?php echo url('logout.php'); ?>" class="flex items-center px-4 py-3 text-slate-500 hover:text-red-400 transition-colors group rounded-xl hover:bg-red-500/5">
            <i data-lucide="log-out" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
            <span class="ml-4 font-bold text-sm hidden lg:block">Terminate Session</span>
        </a>
    </div>
</aside>

<script>
    lucide.createIcons();
</script>
