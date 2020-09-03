<nav class="navbar-default navbar-static-side" role="navigation">
    <?php  
        $user = authentication();
        $uri = service('uri');   
        $uri = current_url(true);
        $uriModule = $uri->getSegment(2);
    ?>
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                    <img alt="image" class="img-circle" src="<?php echo $user['image']; ?>" style="max-width:48px;height:48px;" />
                     </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="<?php echo site_url('profile') ?>">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $user['fullname'] ?></strong>
                     </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url('backend/authentication/auth/logout') ?>">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
           <li class="landing_link">
                <a  href="<?php echo base_url('backend/dashboard/dashboard/index') ?>"><i class="fa fa-star"></i> <span class="nav-label">Dashboard</span> <span class="label label-warning pull-right">NEW</span></a>
            </li>
            <li class="<?php echo ( $uriModule == 'contract') ? 'active'  : '' ?>">
                <a href="index.html"><i class="fa fa-cube"></i> <span class="nav-label">QL Hợp Đồng</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo base_url('backend/contract/hosting/index') ?>">QL Hợp đồng Hosting</a></li>
                    <li><a href="<?php echo base_url('backend/contract/domain/index') ?>">QL Hợp đồng Tên Miền</a></li>
                     <li><a href="<?php echo base_url('backend/contract/website/index') ?>">QL Hợp đồng Website</a></li>
                </ul>
            </li>
            <li class="<?php echo ( $uriModule == 'service') ? 'active'  : '' ?>">
                <a href="index.html"><i class="fa fa-cube"></i> <span class="nav-label">QL Dịch Vụ</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo base_url('backend/service/vps/index') ?>">QL Thông Tin Vps</a></li>
                    <li><a href="<?php echo base_url('backend/service/hosting/index') ?>">QL Báo Gía Hosting</a></li>
                </ul>
            </li>
            <li class="<?php echo ( $uriModule == 'customer') ? 'active'  : '' ?>">
                <a href="index.html"><i class="fa fa-user-o"></i> <span class="nav-label">QL Khách Hàng</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo base_url('backend/customer/catalogue/index') ?>">QL Nhóm Khách Hàng</a></li>
                    <li><a href="<?php echo base_url('backend/customer/customer/index') ?>">QL Khách Hàng</a></li>
                </ul>
            </li>
            <li class="<?php echo ( $uriModule == 'user') ? 'active'  : '' ?>">
                <a href="index.html"><i class="fa fa-user"></i> <span class="nav-label">QL Nhân Sự</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo base_url('backend/user/catalogue/index') ?>">QL Phòng Ban</a></li>
                    <li><a href="<?php echo base_url('backend/user/user/index') ?>">QL Nhân sự</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>