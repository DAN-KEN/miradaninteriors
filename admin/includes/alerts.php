<?php if(isset($sMsg)): ?>
<div class="alert msg-alert abs-alert alert-success mt-auto">
    <?php echo $sMsg; ?>
</div>
<?php endif ?>
<?php if(isset($eMsg)): ?>
<div class="alert msg-alert abs-alert alert-danger mt-auto">
    <?php echo $eMsg; ?>
</div>
<?php endif ?>
<?php if(isset($iMsg)): ?>
<div class="alert msg-alert abs-alert alert-dark mt-auto">
    <?php echo $iMsg; ?>
</div>
<?php endif ?>
<?php if(isset($authMsg)): ?>
<div class="alert msg-alert abs-alert alert-info mt-auto">
    <?php echo $authMsg; ?>
</div>
<?php endif ?>
<?php if(isset($_SESSION['authMsg']) && $_SESSION['authMsg'] != ""): ?>
<div class="alert msg-alert abs-alert alert-info mt-auto">
    <?php echo $_SESSION['authMsg'];  $_SESSION['authMsg'] = ""; ?>
</div>
<?php endif ?>
<?php if(isset($delItem) && $delItem == true): ?>
<div class="alert abs-alert alert-info alert-dismissible">
    <strong>Ahhh!</strong> <?php echo $delMsg; ?>
    <form class="mt-2" action="" method="post">
        <button type="submit" class="btn btn-sm btn-success" name="deleteItem">Yes</button>
        <a href="<?php echo $pageURL; ?>" class="btn btn-sm btn-danger">No</a>
    </form>
</div>
<?php endif ?>
