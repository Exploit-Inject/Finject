<?php
global $route;
$isInternalRoute = (isset($route) && (strpos($route, 'admin/') === 0 || strpos($route, 'user/') === 0 || strpos($route, 'shared/') === 0));
if (is_logged_in() && $isInternalRoute): 
?>
            </div> <!-- End of p-8 max-w-7xl -->
            
            <footer class="mt-auto py-8 text-center border-t border-white/5">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-[3px]">
                    &copy; 2004-2026 ExploitInject | All rights reserved.
                </p>
            </footer>
        </main>
    </div>
<?php else: ?>
    <footer class="py-8 text-center border-t border-white/5 bg-slate-950/50 backdrop-blur-md">
        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[4px]">
            &copy; 2004-2026 ExploitInject | All rights reserved.
        </p>
    </footer>
<?php endif; ?>
</div> <!-- End of wrapper div from header.php -->

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    <?php if (is_logged_in()): ?>
    function markAllRead() {
        fetch('<?php echo url("Shared/notifications.php?action=markRead"); ?>', { method: 'POST' })
            .then(() => window.location.reload());
    }
    <?php endif; ?>
</script>
</body>
</html>
