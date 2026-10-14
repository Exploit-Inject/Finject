<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExploitInject - Finance Dashboard</title>
    
    <!-- Dynamic Favicons -->
    <?php
    $favicon = asset('assets/img/favicon_main.png');
    if (is_admin()) {
        $favicon = asset('assets/img/favicon_admin.png');
    } elseif (is_logged_in()) {
        $favicon = asset('assets/img/favicon_user.png');
    }
    ?>
    <link rel="icon" type="image/png" href="<?php echo $favicon; ?>">
    <link rel="apple-touch-icon" href="<?php echo $favicon; ?>">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo asset('assets/css/style.css'); ?>">
    <script src="<?php echo asset('assets/js/realtime.js'); ?>"></script>
    <script>
        // Theme initialization & Toggle Logic
        (function() {
            const theme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', theme);
        })();

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Dispatch event for components like Charts to react
            window.dispatchEvent(new Event('themeChanged'));
        }
    </script>
</head>
<body class="bg-slate-950 text-slate-100 antialiased">
<?php 
global $route;
$isInternalRoute = (isset($route) && (strpos($route, 'admin/') === 0 || strpos($route, 'user/') === 0 || strpos($route, 'shared/') === 0));
if (is_logged_in() && $isInternalRoute): 
?>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include ROOT_PATH . '/views/shared/sidebar.php'; ?>
        
        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- Topbar (Logged In) -->
            <header class="h-20 glass-card !rounded-none border-b border-white/5 flex items-center justify-between px-8 sticky top-0 z-50">
                <a href="<?php echo url(''); ?>" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-600/30 group-hover:scale-110 transition-all">
                        <i data-lucide="zap" class="w-6 h-6 fill-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black tracking-tighter uppercase italic text-glow">Fin<span class="text-indigo-400">ject</span></h2>
                        <p class="text-[9px] text-slate-500 font-black uppercase tracking-[2px]">Admin Interface</p>
                    </div>
                </a>

                <div class="flex items-center gap-6">
                    <?php if ($route === 'home'): ?>
                        <a href="<?php echo url(is_admin() ? 'Admin/dashboard.php' : 'User/dashboard.php'); ?>" 
                            class="flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white px-6 py-2 rounded-full text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-indigo-600/20">
                            <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                            <span>Console</span>
                        </a>
                    <?php else: ?>
                        <button onclick="document.getElementById('incomeModal').classList.remove('hidden')" 
                            class="flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white px-4 py-2 rounded-full text-sm font-bold transition-all shadow-lg shadow-indigo-600/20">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            <span>Quick Add</span>
                        </button>
                    <?php endif; ?>

                    <div class="h-6 w-px bg-white/10"></div>

                    <?php 
                        $notifModel = new Notification();
                        $unreadCount = $notifModel->getUnreadCount($_SESSION['user_id']);
                        $recentNotifs = $notifModel->getUnread($_SESSION['user_id'], 5);
                    ?>
                    
                    <button onclick="toggleTheme()" class="p-3 text-slate-500 hover:text-indigo-400 bg-white/5 rounded-2xl transition-all">
                        <i data-lucide="sun" class="w-5 h-5 dark-icon"></i>
                        <i data-lucide="moon" class="w-5 h-5 light-icon"></i>
                    </button>

                    <div class="relative group">
                        <button class="p-3 text-slate-500 hover:text-indigo-400 bg-white/5 rounded-2xl transition-all relative">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <span class="bell-badge absolute top-2.5 right-2.5 w-2 h-2 bg-indigo-500 rounded-full border-2 border-[#0A0F1C] <?php echo $unreadCount > 0 ? '' : 'hidden'; ?>"></span>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 top-full pt-2 w-80 hidden group-hover:block z-[9999] animate-fade-in">
                            <div class="bg-[#111827] border border-white/10 p-6 rounded-[24px] shadow-2xl shadow-black/50 backdrop-blur-xl">
                                <div class="flex items-center justify-between mb-6">
                                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[3px]">Notifications (<span class="notification-count-text"><?php echo $unreadCount; ?> Unread</span>)</h4>
                                    <button onclick="markAllRead()" class="text-[9px] font-black text-indigo-400 hover:text-indigo-300 uppercase tracking-widest">Clear All</button>
                                </div>
                                <div class="notification-dropdown-list space-y-4 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar">
                                    <?php if (empty($recentNotifs)): ?>
                                        <div class="text-center py-8">
                                            <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest">No New Intelligence</p>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($recentNotifs as $n): ?>
                                            <a href="<?php echo url($n['link'] ?? 'Shared/notifications.php'); ?>" class="block p-3 rounded-2xl hover:bg-white/5 border border-transparent hover:border-white/5 transition-all group/item">
                                                <p class="text-sm font-bold text-slate-200 mb-1 group-hover/item:text-indigo-400"><?php echo e($n['title']); ?></p>
                                                <p class="text-[11px] text-slate-500 leading-relaxed line-clamp-2"><?php echo e($n['message']); ?></p>
                                            </a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <a href="<?php echo url('Shared/notifications.php'); ?>" class="block text-center mt-6 py-3 border-t border-white/5 text-[10px] font-black text-slate-400 hover:text-white uppercase tracking-[4px] transition-colors">
                                    View Chronicles
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
<?php elseif ($route === 'home'): ?>
    <!-- Pure Public Topbar for Index Page (Premium Dark Facade) -->
    <header class="h-24 flex items-center justify-between px-12 sticky top-0 z-50 bg-[#0A0F1C]/80 backdrop-blur-xl border-b border-white/5">
        <a href="<?php echo url(''); ?>" class="flex items-center gap-3 group">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-600/30 scale-110 transition-all">
                <i data-lucide="zap" class="w-6 h-6 fill-white"></i>
            </div>
            <div>
                <h2 class="text-xl font-black tracking-tighter uppercase italic text-glow">Exploit<span class="text-indigo-400">Inject</span></h2>
                <p class="text-[9px] text-slate-500 font-black uppercase tracking-[2px]">Team Intelligence</p>
            </div>
        </a>

        <div class="flex items-center gap-8">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_10px_#10b981]"></span>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Network Operational</span>
            </div>
            <?php if (is_logged_in()): ?>
                <a href="<?php echo url(is_admin() ? 'Admin/dashboard.php' : 'User/dashboard.php'); ?>" class="text-xs font-black uppercase tracking-widest text-indigo-400 hover:text-indigo-300 transition-colors">Return to Console</a>
            <?php else: ?>
                <div class="h-6 w-px bg-white/10"></div>
                <p class="text-[9px] font-black text-slate-600 uppercase tracking-[4px]">Access Restricted</p>
            <?php endif; ?>
        </div>
    </header>
<?php endif; ?>

<div class="<?php echo ($isInternalRoute && is_logged_in()) ? 'p-8 max-w-7xl mx-auto w-full' : ''; ?>">
<?php if (is_logged_in()) include ROOT_PATH . '/views/shared/income_modal.php'; ?>
