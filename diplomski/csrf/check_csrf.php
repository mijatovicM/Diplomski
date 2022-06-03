<script>
    let perfEntries = performance.getEntriesByType("navigation");
    let p = perfEntries[perfEntries.length - 1];

    if (p.type === 'reload' || p.type === 'back_forward'){
        let url = new URL(window.location.href);
        url.searchParams.set('csrfToken', '<?=generateCsrfToken()?>');
        console.log('')
        window.location.href = url.toString();
    }
</script>
<?php
require_once 'csrf.php';

checkCsrf();
?>