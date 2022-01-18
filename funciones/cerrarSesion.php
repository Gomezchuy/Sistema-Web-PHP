<?php
session_start();
session_destroy();
?>

<script src="../js/jquery-3.3.1.min.js"></script>
<script>
    redirigir();
    function redirigir() {
        window.open('../index.php', '_top');
    }
</script>