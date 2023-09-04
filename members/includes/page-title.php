<div class="pagetitle">
    <h1><i class="fa fa-<?php if(defined("ICON")){print ICON;}else{echo "dashboard";} ?>"></i>
        <?php
        if(defined("PAGE_TITLE")){
            print PAGE_TITLE;
        }
        else{
            echo "Member Dashboard";
        }
        ?>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $membersURL; ?>home"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item active">
                <?php
                if(defined("BREADCRUMB")){
                    print BREADCRUMB;
                }
                else{
                    echo "dashboard";
                }
                ?>
            </li>
        </ol>
    </nav>
</div>
