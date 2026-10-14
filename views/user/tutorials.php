<!-- views/user/tutorials.php -->
<?php 
$pageTitle = 'Agent Academy';
include ROOT_PATH . '/views/shared/header.php'; 
?>

<div class="mb-10 animate-fade-in flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <h1 class="text-5xl font-black text-white tracking-tighter">Agent <span class="text-indigo-500">Academy</span></h1>
        <p class="text-slate-500 font-medium mt-3 text-lg">Master the art of 10x web design and strategic outreach.</p>
    </div>
    <div class="flex items-center gap-4 bg-white/5 p-2 rounded-2xl border border-white/5">
        <div class="px-4 py-2 bg-indigo-500/10 text-indigo-400 rounded-xl text-xs font-black uppercase tracking-widest">Training Active</div>
        <div class="pr-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Lvl 1 Operative</div>
    </div>
</div>

<!-- Main Academy Content -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-16">
    <!-- Tutorials Column -->
    <div class="xl:col-span-2 space-y-8">
        <div class="flex items-center gap-4 mb-2">
            <div class="h-px flex-1 bg-white/5"></div>
            <h2 class="text-[10px] font-black text-slate-600 uppercase tracking-[4px]">Mission Briefings</h2>
            <div class="h-px flex-1 bg-white/5"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php if (empty($tutorials)): ?>
                <div class="col-span-full py-20 text-center glass-card rounded-[40px] border border-dashed border-white/10 bg-slate-900/20">
                    <i data-lucide="lock" class="w-12 h-12 text-slate-700 mx-auto mb-4"></i>
                    <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Academy is preparing new lessons...</p>
                </div>
            <?php else: ?>
                <?php foreach ($tutorials as $tut): ?>
                    <div class="glass-card p-8 rounded-[40px] border border-white/5 hover:border-indigo-500/30 transition-all flex flex-col group relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                             <i data-lucide="<?php echo $tut['media_type'] === 'video' ? 'play' : ($tut['media_type'] === 'audio' ? 'mic' : 'file-text'); ?>" class="w-20 h-20 text-white"></i>
                        </div>
                        
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center border border-indigo-500/10 group-hover:bg-indigo-600 transition-colors">
                                <?php if ($tut['media_type'] === 'video'): ?>
                                    <i data-lucide="play" class="w-5 h-5 text-indigo-400 group-hover:text-white"></i>
                                <?php elseif ($tut['media_type'] === 'audio'): ?>
                                    <i data-lucide="mic" class="w-5 h-5 text-indigo-400 group-hover:text-white"></i>
                                <?php else: ?>
                                    <i data-lucide="file-text" class="w-5 h-5 text-indigo-400 group-hover:text-white"></i>
                                <?php endif; ?>
                            </div>
                            <span class="px-3 py-1 bg-slate-950 border border-white/5 rounded-full text-[9px] font-black uppercase tracking-widest text-slate-500 group-hover:text-slate-300">
                                <?php echo e($tut['media_type']); ?>
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-slate-100 mb-3 group-hover:text-indigo-400 transition-colors"><?php echo e($tut['title']); ?></h3>
                        <p class="text-slate-500 text-sm font-medium mb-8 flex-1 leading-relaxed line-clamp-3">
                            <?php echo e($tut['description']); ?>
                        </p>

                        <?php if ($tut['media_url']): ?>
                            <a href="<?php echo e($tut['media_url']); ?>" target="_blank" class="w-full h-12 bg-white/5 hover:bg-indigo-600/20 text-slate-400 hover:text-indigo-400 border border-white/5 hover:border-indigo-500/30 font-bold rounded-xl transition-all flex items-center justify-center gap-3">
                                <span class="text-xs uppercase tracking-widest">Open Intel</span>
                                <i data-lucide="external-link" class="w-4 h-4"></i>
                            </a>
                        <?php endif; ?>

                        <?php if ($tut['content_text']): ?>
                            <div class="mt-4 p-4 bg-slate-950/50 rounded-2xl border border-white/5 text-slate-400 text-[11px] leading-relaxed max-h-32 overflow-y-auto font-medium">
                                <?php echo nl2br(e($tut['content_text'])); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Playbook Essentials Sidebar -->
    <div class="space-y-8">
        <div class="flex items-center gap-4 mb-2">
            <div class="h-px flex-1 bg-white/5"></div>
            <h2 class="text-[10px] font-black text-slate-600 uppercase tracking-[4px]">Playbook</h2>
            <div class="h-px flex-1 bg-white/5"></div>
        </div>

        <!-- Outreach Script -->
        <div class="glass-card p-8 rounded-[40px] border border-white/5 bg-gradient-to-b from-slate-900/50 to-indigo-900/10">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center border border-amber-500/10">
                    <i data-lucide="message-square" class="w-5 h-5 text-amber-400"></i>
                </div>
                <h4 class="text-sm font-black text-white uppercase tracking-widest">Outreach Script</h4>
            </div>
            <div class="bg-slate-950 p-6 rounded-2xl border border-white/5 relative group">
                <div class="absolute -top-2 -left-2 px-3 py-1 bg-indigo-600 text-[10px] font-black rounded-lg text-white opacity-0 group-hover:opacity-100 transition-opacity">COPY READY</div>
                <p class="font-mono text-sm text-indigo-200 leading-relaxed italic">
                    "Hey, I'm [Name]. I noticed your website [problem]. I've made a free demo for you. If you like it, we can talk. No pressure at all."
                </p>
            </div>
            <p class="text-[10px] text-slate-500 mt-4 font-bold uppercase tracking-wider text-center">Pro Tip: Use a friendly, low-pressure tone</p>
        </div>

        <!-- Workflow Process -->
        <div class="glass-card p-8 rounded-[40px] border border-white/5">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center border border-emerald-500/10">
                    <i data-lucide="zap" class="w-5 h-5 text-emerald-400"></i>
                </div>
                <h4 class="text-sm font-black text-white uppercase tracking-widest">The Workflow</h4>
            </div>
            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-slate-900 border border-white/10 flex items-center justify-center text-xs font-black text-indigo-400 shrink-0">1</div>
                    <div>
                        <div class="text-sm font-bold text-slate-200">Hostinger Setup</div>
                        <div class="text-[11px] text-slate-500">Sign up via Horizons to get agent benefits.</div>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-slate-900 border border-white/10 flex items-center justify-center text-xs font-black text-indigo-400 shrink-0">2</div>
                    <div>
                        <div class="text-sm font-bold text-slate-200">AI Prompting</div>
                        <div class="text-[11px] text-slate-500">Use Claude for logic and Lovable for UI.</div>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-slate-900 border border-white/10 flex items-center justify-center text-xs font-black text-indigo-400 shrink-0">3</div>
                    <div>
                        <div class="text-sm font-bold text-slate-200">Demo Delivery</div>
                        <div class="text-[11px] text-slate-500">Send the link and wait for the "Wow".</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

<?php include ROOT_PATH . '/views/shared/footer.php'; ?>
