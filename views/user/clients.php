<!-- views/user/clients.php -->
<?php 
$pageTitle = 'Our Target Clients';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="mb-10 animate-fade-in">
    <h1 class="text-4xl font-black text-white tracking-tight">Our <span class="text-indigo-400">Target Clients</span></h1>
    <p class="text-slate-500 font-medium mt-2">Profitable niches and markets where ExploitInject thrives.</p>
</div>

<!-- Niches Section -->
<div class="mb-16">
    <div class="flex items-center gap-4 mb-8">
        <div class="h-px flex-1 bg-white/5"></div>
        <h2 class="text-xs font-black text-slate-500 uppercase tracking-[4px]">High-Potential Niches</h2>
        <div class="h-px flex-1 bg-white/5"></div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        $niches = [
            ['icon' => '🦷', 'title' => 'Dental Clinics & Doctors', 'reason' => 'Need appointment booking, patient trust-building. Already profitable. Easy recurring work.', 'badge' => 'High Budget', 'badge_color' => 'emerald'],
            ['icon' => '🏋️', 'title' => 'Gyms & Fitness Centers', 'reason' => 'Membership model = they understand monthly payments. Want class schedules, trainer profiles.', 'badge' => 'Recurring Income', 'badge_color' => 'amber'],
            ['icon' => '🏠', 'title' => 'Real Estate Agents', 'reason' => 'Need property listings, WhatsApp integration, contact forms. Ready to invest in lead tools.', 'badge' => 'High Intent', 'badge_color' => 'indigo'],
            ['icon' => '📚', 'title' => 'Coaching Institutes', 'reason' => 'Need professional presence for admissions. Competition is high so they are motivated.', 'badge' => 'Volume Market', 'badge_color' => 'purple'],
            ['icon' => '🏗️', 'title' => 'Contractors & Interior Designers', 'reason' => 'Build houses but have no web presence. Earn well. Easy to show portfolio value.', 'badge' => 'Easy Close', 'badge_color' => 'rose'],
            ['icon' => '🚀', 'title' => 'Local Startups', 'reason' => 'Have vision AND budget. More tech-savvy. Want add-ons like SEO, analytics, chat bots.', 'badge' => 'Best Upsell', 'badge_color' => 'sky']
        ];
        
        foreach ($niches as $niche): ?>
            <div class="glass-card p-8 rounded-[32px] border border-white/5 hover:border-indigo-500/30 transition-all group">
                <div class="text-4xl mb-6 group-hover:scale-110 transition-transform"><?php echo $niche['icon']; ?></div>
                <h3 class="text-xl font-bold text-slate-100 mb-3"><?php echo $niche['title']; ?></h3>
                <p class="text-slate-500 text-sm leading-relaxed mb-6"><?php echo $niche['reason']; ?></p>
                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-<?php echo $niche['badge_color']; ?>-500/10 text-<?php echo $niche['badge_color']; ?>-400 border border-<?php echo $niche['badge_color']; ?>-500/20">
                    <?php echo $niche['badge']; ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Markets Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
    <div class="glass-card p-8 rounded-[40px] border border-white/5 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-10">
            <i data-lucide="map" class="w-24 h-24 text-indigo-400"></i>
        </div>
        <h3 class="text-xl font-black text-white mb-6">🇮🇳 India <span class="text-slate-500 font-medium text-sm">Tier 2 & 3</span></h3>
        <div class="flex flex-wrap gap-2 mb-8">
            <?php foreach (['Indore', 'Lucknow', 'Surat', 'Nasik', 'Jaipur', 'Bhopal'] as $city): ?>
                <span class="px-3 py-1.5 bg-slate-900 border border-white/5 rounded-xl text-[10px] font-bold text-slate-400 uppercase tracking-wider"><?php echo $city; ?></span>
            <?php endforeach; ?>
        </div>
        <ul class="space-y-4 text-[11px] font-medium text-slate-500">
            <li class="flex items-start gap-3"><i data-lucide="check-circle-2" class="w-4 h-4 text-indigo-500 shrink-0"></i> Money available, low competition</li>
            <li class="flex items-start gap-3"><i data-lucide="check-circle-2" class="w-4 h-4 text-indigo-500 shrink-0"></i> Clients negotiate less than Tier 1</li>
        </ul>
    </div>

    <div class="glass-card p-8 rounded-[40px] border border-white/5 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-10">
            <i data-lucide="globe" class="w-24 h-24 text-emerald-400"></i>
        </div>
        <h3 class="text-xl font-black text-white mb-6">🇧🇩 Bangladesh <span class="text-slate-500 font-medium text-sm">Native Advantage</span></h3>
        <div class="flex flex-wrap gap-2 mb-8">
            <?php foreach (['Dhaka', 'Sylhet', 'Chittagong', 'Comilla', 'Khulna'] as $city): ?>
                <span class="px-3 py-1.5 bg-slate-900 border border-white/5 rounded-xl text-[10px] font-bold text-slate-400 uppercase tracking-wider"><?php echo $city; ?></span>
            <?php endforeach; ?>
        </div>
        <ul class="space-y-4 text-[11px] font-medium text-slate-500">
            <li class="flex items-start gap-3"><i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 shrink-0"></i> Native culture + language edge</li>
            <li class="flex items-start gap-3"><i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500 shrink-0"></i> Almost no organized local competition</li>
        </ul>
    </div>

    <div class="glass-card p-8 rounded-[40px] border border-white/5 relative overflow-hidden bg-indigo-600/5">
        <div class="absolute top-0 right-0 p-8 opacity-10">
            <i data-lucide="zap" class="w-24 h-24 text-purple-400"></i>
        </div>
        <h3 class="text-xl font-black text-white mb-6">🌎 International <span class="text-indigo-400 font-medium text-sm">High Ticket</span></h3>
        <div class="flex flex-wrap gap-2 mb-8">
            <?php foreach (['USA', 'UK', 'Australia', 'Canada', 'Germany', 'UAE'] as $region): ?>
                <span class="px-3 py-1.5 bg-indigo-500/10 border border-indigo-500/20 rounded-xl text-[10px] font-bold text-indigo-400 uppercase tracking-wider"><?php echo $region; ?></span>
            <?php endforeach; ?>
        </div>
        <ul class="space-y-4 text-[11px] font-medium text-slate-500">
            <li class="flex items-start gap-3"><i data-lucide="check-circle-2" class="w-4 h-4 text-purple-500 shrink-0"></i> High Budget (USD / GBP / EUR)</li>
            <li class="flex items-start gap-3"><i data-lucide="check-circle-2" class="w-4 h-4 text-purple-500 shrink-0"></i> Value-based pricing model works best</li>
        </ul>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
