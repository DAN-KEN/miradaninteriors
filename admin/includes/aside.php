<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="<?php echo $adminURL; ?>home?shw-pend=admin">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <?php if($curAdRole == "Owner" || $curAdRole == "Super Admin"): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#item-nav-new" data-bs-toggle="collapse" href="#">
                <i class="fa fa-plus"></i><span>New</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="item-nav-new" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li><a href="<?php echo $adminURL; ?>users?sz=min&prf=new-user&vw=users"><i class="bi bi-circle"></i><span>Admin</span></a></li>
                <li><a href="<?php echo $adminURL; ?>users?sz=min&prf=new-role&vw=roles"><i class="bi bi-circle"></i><span>User Role</span></a></li>
                <li><a href="<?php echo $adminURL; ?>users?sz=min&prf=new-member&vw=members"><i class="bi bi-circle"></i><span>Member</span></a></li>
            </ul>
        </li><!-- End New Item Nav -->
        <?php endif ?>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#item-nav-manage" data-bs-toggle="collapse" href="#">
                <i class="fa fa-edit"></i><span>Manage</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="item-nav-manage" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li><a href="<?php echo $adminURL; ?>users?vw=users"><i class="bi bi-circle"></i><span>Admin</span></a></li>
                <li><a href="<?php echo $adminURL; ?>users?vw=roles"><i class="bi bi-circle"></i><span>User Roles</span></a></li>
                <li><a href="<?php echo $adminURL; ?>users?vw=members"><i class="bi bi-circle"></i><span>Members</span></a></li>
            </ul>
        </li><!-- End New Item Nav -->

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo $adminURL; ?>users?vw=users">
                <i class="fa fa-users"></i>
                <span>Admin</span>
            </a>
            <a class="nav-link collapsed" href="<?php echo $adminURL; ?>users?vw=members">
                <i class="fa fa-users"></i>
                <span>Members</span>
            </a>
            <a class="nav-link collapsed" href="<?php echo $adminURL; ?>users?vw=roles">
                <i class="fa fa-id-card"></i>
                <span>User Roles</span>
            </a>
            <a class="nav-link collapsed" href="<?php echo $adminURL; ?>template">
                <i class="fa fa-file"></i>
                <span>Template</span>
            </a>
        </li>

    </ul>

</aside>
