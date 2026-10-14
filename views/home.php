<!-- views/home.php -->
<?php 
// Public ultra-premium dark landing page
$incomeModel = new Income();
$distModel = new Distribution();

$totalIncome = $incomeModel->getTotalIncome();
$monthlyStats = $incomeModel->getMonthlyStats();
$distribution = $distModel->getAggregatedTransactions();
$settings = $distModel->getSettings(); // Live splitting revenue set by Admin

$pageTitle = 'ExploitInject - Team Intelligence';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<!-- Aurora Background Layers -->
<div class="aurora-bg">
    <div class="aurora-blob bg-indigo-600/10 w-[800px] h-[800px] -top-[400px] -left-[200px]" style="animation-duration: 25s;"></div>
    <div class="aurora-blob bg-violet-600/10 w-[600px] h-[600px] top-[20%] -right-[100px]" style="animation-delay: -5s; animation-duration: 20s;"></div>
    <div class="aurora-blob bg-blue-600/5 w-[700px] h-[700px] -bottom-[200px] left-[10%]" style="animation-delay: -10s; animation-duration: 30s;"></div>
</div>

<div class="max-w-7xl mx-auto px-12 pt-24 pb-32 relative z-10">
    <!-- Hero Branding -->
    <div class="text-center mb-32 animate-fade-in">
        <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full bg-white/5 border border-white/5 mb-10 backdrop-blur-md">
            <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_8px_#6366f1]"></span>
            <span class="text-[10px] font-black uppercase tracking-[5px] text-slate-400">Ledger Protocol Node-01 Active</span>
        </div>
        <h1 class="retina-heading text-8xl md:text-[120px] mb-12 text-white">
            <span class="text-gradient">Consensus</span>
        </h1>
        <p class="text-xl md:text-2xl text-slate-400 font-medium max-w-2xl mx-auto leading-relaxed mb-8">
            The secured standard for team revenue allocation. <br class="hidden md:block"/>
            Automated splitting. Atomic transparency. Elite integrity.
        </p>
    </div>

    <!-- The Visual Analytics (Premium Dark Version) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-32">
        <!-- Revenue Growth Card -->
        <div class="glass-card stat-card p-12 group">
            <div class="stat-glow top-0 left-0"></div>
            <div class="flex items-center gap-5 mb-12 relative z-10">
                <div class="w-14 h-14 bg-indigo-500/10 text-indigo-400 rounded-2xl flex items-center justify-center border border-indigo-500/20 shadow-lg shadow-indigo-500/10">
                    <i data-lucide="bar-chart-3" class="w-7 h-7"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-black tracking-tight text-white mb-1">Growth Index</h3>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Cumulative Revenue Velocity</p>
                </div>
            </div>
            <div class="h-[400px] w-full relative z-10">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        <!-- Allocation Split Card -->
        <div class="glass-card stat-card p-12 group">
            <div class="stat-glow top-0 right-0"></div>
            <div class="flex items-center gap-5 mb-12 relative z-10">
                <div class="w-14 h-14 bg-violet-500/10 text-violet-400 rounded-2xl flex items-center justify-center border border-violet-500/20 shadow-lg shadow-violet-500/10">
                    <i data-lucide="pie-chart" class="w-7 h-7"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-black tracking-tight text-white mb-1">Split Protocol</h3>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Automated Distribution Logic</p>
                </div>
            </div>
            
            <div class="flex flex-col items-center relative z-10">
                <div class="w-72 h-72 mb-16 relative">
                    <canvas id="splitChart"></canvas>
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="text-center">
                            <p class="text-[9px] font-black text-slate-600 uppercase tracking-widest">Status</p>
                            <p class="text-2xl font-black text-indigo-400">Verifed</p>
                        </div>
                    </div>
                </div>
                
                <div class="w-full space-y-3">
                    <div class="flex items-center justify-between p-4 bg-white/[0.02] border border-white/5 rounded-2xl hover:bg-white/[0.04] transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-2 rounded-full bg-[#6366F1] shadow-[0_0_10px_#6366f1]"></div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[2px]">Startup capitalization</span>
                        </div>
                        <span class="text-lg font-black text-indigo-400"><?php echo $settings['startup_pct']; ?>%</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-white/[0.02] border border-white/5 rounded-2xl hover:bg-white/[0.04] transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-2 rounded-full bg-[#8B5CF6] shadow-[0_0_10px_#8b5cf6]"></div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[2px]">Member Pool share</span>
                        </div>
                        <span class="text-lg font-black text-violet-400"><?php echo $settings['member_pct']; ?>%</span>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-white/[0.02] border border-white/5 rounded-2xl hover:bg-white/[0.04] transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-2 rounded-full bg-[#F59E0B] shadow-[0_0_10px_#f59e0b]"></div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[2px]">execution flow</span>
                        </div>
                        <span class="text-lg font-black text-orange-400"><?php echo $settings['execution_pct']; ?>%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Infrastructure Footer Area -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-32">
        <div class="p-8 border-l border-white/5">
            <h4 class="text-sm font-black text-indigo-400 uppercase tracking-[4px] mb-4">Secured Ops</h4>
            <p class="text-sm text-slate-500 leading-relaxed">Every signal is hash-verified against team protocols to prevent unauthorized movement.</p>
        </div>
        <div class="p-8 border-l border-white/5">
            <h4 class="text-sm font-black text-violet-400 uppercase tracking-[4px] mb-4">Deep Insights</h4>
            <p class="text-sm text-slate-500 leading-relaxed">The omniscience of our Intelligence Filter providing 100% clarity on long-term growth.</p>
        </div>
        <div class="p-8 border-l border-white/5">
            <h4 class="text-sm font-black text-emerald-400 uppercase tracking-[4px] mb-4">99.9% Uptime</h4>
            <p class="text-sm text-slate-500 leading-relaxed">Infrastructure stability maintained through distributed redundancy and load protocols.</p>
        </div>
    </div>

    <div class="text-center py-20 border-t border-white/5">
        <h2 class="text-4xl font-black text-white mb-6 tracking-tighter">Team ExploitInject Automated Ledger</h2>
        <p class="text-slate-500 font-medium max-w-xl mx-auto mb-10 text-sm italic">Restricted portal for authorized identities only. Unauthorized decryption attempt will be logged.</p>
        <div class="flex items-center justify-center gap-6 text-[10px] font-black text-slate-700 uppercase tracking-[5px]">
            <span>NODE-4.0-SECURED</span>
            <div class="w-1.5 h-1.5 bg-indigo-900 rounded-full"></div>
            <span>INTEL-FLOW-ON</span>
        </div>
    </div>
</div>

<script>
// Premium Dynamic Charts with Soft Glows
const growthCtx = document.getElementById('growthChart').getContext('2d');
const gradient = growthCtx.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(99, 102, 241, 0.2)');
gradient.addColorStop(1, 'rgba(139, 92, 246, 0)');

new Chart(growthCtx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_column($monthlyStats, 'month')); ?>,
        datasets: [{
            data: <?php echo json_encode(array_column($monthlyStats, 'total')); ?>,
            borderColor: '#6366f1',
            borderWidth: 4,
            tension: 0.4,
            fill: true,
            backgroundColor: gradient,
            pointBackgroundColor: '#8B5CF6',
            pointBorderColor: '#0A0F1C',
            pointBorderWidth: 4,
            pointRadius: 6,
            pointHoverRadius: 8,
            pointHoverBorderWidth: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { grid: { color: 'rgba(255, 255, 255, 0.03)', drawBorder: false }, ticks: { color: '#6B7280', font: { weight: '700', size: 10 } } },
            x: { grid: { display: false }, ticks: { color: '#6B7280', font: { weight: '800', size: 10 } } }
        }
    }
});

new Chart(document.getElementById('splitChart'), {
    type: 'doughnut',
    data: {
        labels: ['Startup', 'Members', 'Execution'],
        datasets: [{
            data: [
                <?php echo $settings['startup_pct']; ?>, 
                <?php echo $settings['member_pct']; ?>, 
                <?php echo $settings['execution_pct']; ?>
            ],
            backgroundColor: ['#6366F1', '#8B5CF6', '#F59E0B'],
            borderWidth: 0,
            hoverOffset: 15,
            spacing: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '85%',
        layout: {
            padding: 20
        },
        plugins: { 
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(10, 15, 28, 0.9)',
                titleFont: { size: 12, weight: 'bold' },
                bodyFont: { size: 12, weight: 'bold' },
                padding: 12,
                cornerRadius: 12,
                displayColors: false
            }
        }
    }
});

lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
