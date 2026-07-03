<?php
// Inyectar variables de entorno como objeto JavaScript global
header('Content-Type: application/javascript');
?>
window.ENV = {
    SUPABASE_URL: '<?php echo getenv('SUPABASE_URL'); ?>',
    SUPABASE_ANON_KEY: '<?php echo getenv('SUPABASE_ANON_KEY'); ?>'
};
