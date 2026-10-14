<!-- views/admin/dashboard.php -->
<?php 
$pageTitle = 'Dashboard Overview';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="mb-10 animate-fade-in">
    <h1 class="text-3xl font-black tracking-tight mb-2">Metrics <span class="text-indigo-500">Overview</span></h1>
    <p class="text-slate-400 text-sm font-medium">Real-time revenue monitoring and team distribution.</p>
</div>

<!-- Stats Horizontal Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <!-- Total Revenue -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden group">
        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
            <i data-lucide="globe" class="w-16 h-16 text-indigo-500"></i>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <div class="w-10 h-10 bg-indigo-500/10 text-indigo-400 rounded-xl flex items-center justify-center">
                <i data-lucide="database" class="w-5 h-5"></i>
            </div>
            <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">Lifetime Capital</span>
        </div>
        <div class="text-3xl font-black tracking-tighter" data-stat="total_income"><?php echo format_currency($stats['total_income']); ?></div>
        <div class="mt-2 text-xs text-slate-500 font-medium whitespace-nowrap overflow-hidden text-ellipsis">System-wide accumulation</div>
    </div>

    <!-- Yearly -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden group border-indigo-500/10">
        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
            <i data-lucide="calendar-check" class="w-16 h-16 text-purple-500"></i>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <div class="w-10 h-10 bg-purple-500/10 text-purple-400 rounded-xl flex items-center justify-center">
                <i data-lucide="trending-up" class="w-5 h-5"></i>
            </div>
            <span class="text-[10px] font-black text-purple-400 uppercase tracking-widest">Yearly Volume</span>
        </div>
        <div class="text-3xl font-black tracking-tighter" data-stat="yearly_total"><?php echo format_currency($stats['yearly_total']); ?></div>
        <div class="mt-2 text-xs text-slate-500 font-medium">Fiscal year performance</div>
    </div>

    <!-- Monthly -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden group">
        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
            <i data-lucide="layers" class="w-16 h-16 text-blue-500"></i>
        </div>
        <div class="flex items-center gap-4 mb-4">
            <div class="w-10 h-10 bg-blue-500/10 text-blue-400 rounded-xl flex items-center justify-center">
                <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
            </div>
            <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Monthly Intake</span>
        </div>
        <div class="text-3xl font-black tracking-tighter" data-stat="monthly_total"><?php echo format_currency($stats['monthly_total']); ?></div>
        <div class="mt-2 text-xs text-slate-500 font-medium">Current active cycle</div>
    </div>

    <!-- Daily -->
    <div class="glass-card p-6 rounded-3xl relative overflow-hidden group border-emerald-500/20">
        <div class="absolute -right-2 -top-2 w-24 h-24 bg-emerald-500/5 rounded-full blur-3xl group-hover:bg-emerald-500/10 transition-colors"></div>
        <div class="flex items-center gap-4 mb-4">
            <div class="w-10 h-10 bg-emerald-500/10 text-emerald-400 rounded-xl flex items-center justify-center">
                <i data-lucide="activity" class="w-5 h-5"></i>
            </div>
            <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Daily Velocity</span>
        </div>
        <div class="text-3xl font-black tracking-tighter text-emerald-400" data-stat="daily_total"><?php echo format_currency($stats['daily_total']); ?></div>
        <div class="mt-2 text-xs text-slate-500 font-medium">Real-time telemetry</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
    <!-- Large Chart Card -->
    <div class="lg:col-span-2 glass-card p-8 rounded-3xl">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-sm font-black uppercase tracking-[3px] text-slate-400">Revenue Performance</h3>
            <div class="flex gap-2">
                <span class="w-3 h-3 bg-indigo-500 rounded-full"></span>
                <span class="text-[10px] font-bold text-slate-500 uppercase">Primary Stream</span>
            </div>
        </div>
        <div class="h-[350px] w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Distribution Progress Card -->
    <div class="glass-card p-8 rounded-3xl flex flex-col">
        <h3 class="text-sm font-black uppercase tracking-[3px] text-slate-400 mb-8">Allocation Split</h3>
        
        <div class="flex-1 flex flex-col justify-center space-y-10">
            <!-- Startup -->
            <div class="space-y-3">
                <div class="flex justify-between items-end">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Startup Capital</span>
                    <span class="text-lg font-black text-indigo-400"><?php echo format_currency($stats['distribution']['total_startup'] ?? 0); ?></span>
                </div>
                <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-indigo-600 to-indigo-400 rounded-full transition-all duration-1000" style="width: 40%"></div>
                </div>
            </div>

            <!-- Members -->
            <div class="space-y-3">
                <div class="flex justify-between items-end">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Member Pool</span>
                    <span class="text-lg font-black text-purple-400"><?php echo format_currency($stats['distribution']['total_member'] ?? 0); ?></span>
                </div>
                <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-purple-600 to-purple-400 rounded-full transition-all duration-1000" style="width: 40%"></div>
                </div>
            </div>

            <!-- Execution -->
            <div class="space-y-3">
                <div class="flex justify-between items-end">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Execution Flow</span>
                    <span class="text-lg font-black text-orange-400"><?php echo format_currency($stats['distribution']['total_execution'] ?? 0); ?></span>
                </div>
                <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-orange-600 to-orange-400 rounded-full transition-all duration-1000" style="width: 20%"></div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-8 border-t border-white/5">
            <div class="flex items-center justify-between text-[10px] font-black text-slate-600 uppercase tracking-widest">
                <span>Total Shared</span>
                <span class="text-emerald-500">100% Effective</span>
            </div>
        </div>
    </div>
</div>

<script>
let revenueChart;
function initChart() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
    const tickColor = isDark ? '#64748b' : '#475569';
    
    const revCtx = document.getElementById('revenueChart').getContext('2d');
    const gradient = revCtx.createLinearGradient(0, 0, 0, 350);
    gradient.addColorStop(0, isDark ? 'rgba(99, 102, 241, 0.2)' : 'rgba(99, 102, 241, 0.1)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

    if (revenueChart) revenueChart.destroy();

    revenueChart = new Chart(revCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_column($stats['monthly_stats'], 'month')); ?>,
            datasets: [{
                label: 'Revenue',
                data: <?php echo json_encode(array_column($stats['monthly_stats'], 'total')); ?>,
                borderColor: '#6366f1',
                borderWidth: 4,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: isDark ? '#0f172a' : '#ffffff',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8,
                tension: 0.45,
                fill: true,
                backgroundColor: gradient
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDark ? '#1e293b' : '#ffffff',
                    titleColor: isDark ? '#ffffff' : '#0f172a',
                    bodyColor: isDark ? '#cbd5e1' : '#475569',
                    padding: 12,
                    cornerRadius: 12,
                    displayColors: false,
                    borderWidth: isDark ? 0 : 1,
                    borderColor: 'rgba(0,0,0,0.1)'
                }
            },
            scales: {
                y: {
                    grid: { color: gridColor, drawBorder: false },
                    ticks: { color: tickColor, font: { size: 10, weight: 'bold' }, padding: 10 }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: tickColor, font: { size: 10, weight: 'bold' }, padding: 10 }
                }
            }
        }
    });
}

// Initial draw
initChart();

// Re-draw on theme change
window.addEventListener('themeChanged', initChart);

// Re-init lucide
lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
