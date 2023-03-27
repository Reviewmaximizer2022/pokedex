<?php

session_start();
    if(isset($_SESSION['errors'])) :
?>
<div class="alert alert-danger text-center mx-5">
    <?= $_SESSION['errors'] ?>
</div>
<?php
    unset($_SESSION['errors']);
    endif;
?>