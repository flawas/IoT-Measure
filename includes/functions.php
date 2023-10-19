<?php

function createAlertBadgeURL() {
    $text = $_GET['text'];
    $status = $_GET['status'];
    createAlertBadge($text, $status);
}


function createAlertBadge($text, $status) {

    if($status == "success") {
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?php echo $text;?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
    }

    if($status == "error") {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?php echo $text;?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
    }
}

?>