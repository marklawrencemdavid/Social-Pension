<?php if(basename($_SERVER['PHP_SELF']) == 'sidebar.php'){header('location: dashboard');}?>
<!-- <aside class="main-sidebar sidebar-dark-primary elevation-4" id="sidebartag"> -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-no-expand" id="sidebartag">
    <!-- Brand Logo -->
    <a href="/admin/dashboard" class="brand-link">
        <?php if($pages['page_website_icon'] != 'no_image.png'){ ?>
            <img src="/assets/img/uploads/<?php echo $pages['page_website_icon']; ?>" alt="Logo" class="brand-image img-circle elevation-3">
        <?php } ?>
        <span class="brand-text font-weight-light"><?php echo $pages['page_website_title']; ?></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar" style="overflow-x: hidden;">
        <!-- SidebarSearch Form -->
        <div class="form-inline mt-3 mb-3 d-flex">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search Tab" aria-label="Search">
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <!-- <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-flat nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false"> -->
            <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false"> 
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="/admin/dashboard" class="nav-link  <?php if ($curPageName == 'dashboard.php') { echo 'active'; } ?>">
                        <i class="fas fa-tachometer-alt nav-icon"></i><p>Dashboard</p>
                    </a>
                </li>
                <!-- Analytics -->
                <li class="nav-item">
                    <a href="/admin/analytics" class="nav-link  <?php if ($curPageName == 'analytics.php') { echo 'active'; } ?>">
                        <i class="fas fa-chart-bar nav-icon"></i><p>Analytics</p>
                    </a>
                </li>
                <!-- Pages -->
                <li class="nav-item <?php if ($curPageName == 'general.php' || $curPageName == 'register_for_social_pension.php' || $curPageName == 'portfolio.php' || $curPageName == 'accomplishment_reports.php' || $curPageName == 'mission_and_vision.php' || $curPageName == 'officials.php' || $curPageName == 'frequently-asked-questions.php') { echo 'menu-is-opening menu-open'; }?>">
                    <a href="#" class="nav-link <?php if ($curPageName == 'general.php' || $curPageName == 'register_for_social_pension.php' || $curPageName == 'portfolio.php' || $curPageName == 'accomplishment_reports.php' || $curPageName == 'mission_and_vision.php' || $curPageName == 'officials.php' || $curPageName == 'frequently-asked-questions.php') { echo 'active'; }?>">
                        <i class="fas fa-book nav-icon"></i><p>Website Pages<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/website_pages/general" class="nav-link <?php if ($curPageName == 'general.php') { echo 'active'; } ?>">
                                <i class="fas fa-ellipsis-h nav-icon"></i><p>General</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/website_pages/mission_and_vision" class="nav-link <?php if ($curPageName == 'mission_and_vision.php') { echo 'active'; } ?>">
                                <i class="fas fa-flag nav-icon"></i><p>Mission and Vision</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/website_pages/officials" class="nav-link <?php if ($curPageName == 'officials.php') { echo 'active'; } ?>">
                                <i class="fas fa-users nav-icon"></i><p>Officials</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/website_pages/register_for_social_pension" class="nav-link <?php if ($curPageName == 'register_for_social_pension.php') { echo 'active'; } ?>">
                                <i class="fas fa-plus-circle nav-icon"></i><p>Register for SPISC</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/website_pages/frequently-asked-questions" class="nav-link <?php if ($curPageName == 'frequently-asked-questions.php') { echo 'active'; } ?>">
                                <i class="fas fa-question-circle nav-icon"></i><p>FAQs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/website_pages/portfolio" class="nav-link <?php if ($curPageName == 'portfolio.php') { echo 'active'; } ?>">
                                <i class="fas fa-folder nav-icon"></i><p>Portfolio</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/website_pages/accomplishment_reports" class="nav-link <?php if ($curPageName == 'accomplishment_reports.php') { echo 'active'; } ?>">
                                <i class="fas fa-file-alt nav-icon"></i><p>Accomplisment Reports</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Applicants -->
                <li class="nav-item <?php if ($curPageName == 'add_new.php' || $curPageName == 'applicants.php' || $curPageName == 'rejected.php' || $curPageName == 'spam.php') { echo 'menu-is-opening menu-open'; }?>">
                    <a href="#" class="nav-link <?php if ($curPageName == 'add_new.php' || $curPageName == 'applicants.php' || $curPageName == 'rejected.php' || $curPageName == 'spam.php') { echo 'active'; }?>">
                        <i class="nav-icon fas fa-copy"></i><p><i class="right fas fa-angle-left"></i> Applicants </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/applicants/add_new" class="nav-link <?php if ($curPageName == 'add_new.php') { echo 'active'; } ?>">
                                <i class="fas fa-plus-circle nav-icon"></i><p>Add New</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/applicants/applicants" class="nav-link <?php if ($curPageName == 'applicants.php') { echo 'active'; } ?>">
                                <i class="fas fa-file-alt nav-icon"></i><p>Applicants</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/applicants/rejected" class="nav-link <?php if ($curPageName == 'rejected.php') { echo 'active'; } ?>">
                                <i class="fas fa-user-alt-slash nav-icon"></i><p>Rejected</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/applicants/spam" class="nav-link <?php if ($curPageName == 'spam.php') { echo 'active'; } ?>">
                                <i class="fas fa-exclamation-circle nav-icon"></i><p>Spam</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Pensioners -->
                <li class="nav-item <?php if ($curPageName == 'active.php' || $curPageName == 'purchase_booklet.php' || $curPageName == 'deceased.php' || $curPageName == 'pensioner.php') { echo 'menu-is-opening menu-open'; }?>">
                    <a href="#" class="nav-link <?php if ($curPageName == 'active.php' || $curPageName == 'purchase_booklet.php' || $curPageName == 'deceased.php' || $curPageName == 'pensioner.php') { echo 'active'; }?>">
                        <i class="nav-icon fas fa-users"></i><p><i class="right fas fa-angle-left"></i> Pensioners </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/pensioners/active" class="nav-link <?php if ($curPageName == 'active.php' || ($curPageName == 'pensioner.php' && $appl['appl_status'] == 'Active')) { echo 'active'; } ?>">
                                <i class="fas fa-user-alt nav-icon"></i><p>Active <?php if ($curPageName == 'pensioner.php' && $appl['appl_status'] == 'Active') { echo '/ Pensioner'; } ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/pensioners/purchase_booklet" class="nav-link <?php if ($curPageName == 'purchase_booklet.php') { echo 'active'; } ?>">
                                <i class="fas fa-receipt nav-icon"></i><p>Purchase Booklet</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/pensioners/deceased" class="nav-link <?php if ($curPageName == 'deceased.php' || ($curPageName == 'pensioner.php' && $appl['appl_status'] == 'Deceased')) { echo 'active'; } ?>">
                                <i class="fas fa-skull-crossbones nav-icon"></i><p>Deceased <?php if ($curPageName == 'pensioner.php' && $appl['appl_status'] == 'Deceased') { echo '/ Pensioner'; } ?></p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- SMS -->
                <li class="nav-item">
                    <a href="/admin/sms" class="nav-link <?php if ($curPageName == 'sms.php'){ echo 'active';}?>">
                        <i class="nav-icon fas fa-comment-alt"></i><p>SMS</p>
                    </a>
                </li>
                <!-- Notification -->
                <li class="nav-item">
                    <a href="/admin/notifications" class="nav-link <?php if ($curPageName == 'notifications.php'){ echo 'active';}?>">
                        <i class="nav-icon fas fa-bell"></i><p>Notifications<span class="badge badge-primary right" id="noti_number_sidebar"></span></p>
                    </a>
                </li>
                <!-- Multi Tabs -->
                <li class="nav-item">
                    <a href="/admin/<?php if ($curPageName != 'multitab.php') { echo 'multitab';}else{echo '#';} ?>" class="nav-link <?php if ($curPageName == 'multitab.php') { echo 'active'; } ?>">
                        <i class="nav-icon fas fa-window-restore"></i><p>Multi Tabs</p>
                    </a>
                </li>
                <!-- Accounts -->
                <li class="nav-item <?php if ($curPageName == 'create_account.php' || $curPageName == 'all_accounts.php' || $curPageName == 'profile.php' || $curPageName == 'profile_settings.php'){ echo 'menu-is-opening menu-open';}?>">
                    <a href="#" class="nav-link <?php if ($curPageName == 'create_account.php' || $curPageName == 'all_accounts.php' || $curPageName == 'profile.php' || $curPageName == 'profile_settings.php'){ echo 'active';}?>">
                        <i class="fas fa-user nav-icon"></i><p>Accounts <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if ($acc['acc_role'] != 'Staff') { ?>
                            <li class="nav-item">
                                <a href="/admin/accounts/create_account" class="nav-link <?php if ($curPageName == 'create_account.php'){ echo 'active';}?>">
                                    <i class="fas fa-user-plus nav-icon"></i><p>Create Account</p>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a href="/admin/accounts/all_accounts" class="nav-link <?php if ($curPageName == 'all_accounts.php'){ echo 'active';}?>">
                                <i class="fas fa-users nav-icon"></i><p>All Accounts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/accounts/profile" class="nav-link <?php if ($curPageName == 'profile.php' || $curPageName == 'profile_settings.php'){ echo 'active';}?>">
                                <i class="fas fa-user nav-icon"></i><p>Profile <?php if ($curPageName == 'profile_settings.php'){ echo '/ Settings';}?></p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php if ($acc['acc_role'] != 'Staff') { ?>
                    <!-- Activity Log -->
                    <li class="nav-item">
                        <a href="/admin/activity_log" class="nav-link <?php if ($curPageName == 'activity_log.php'){ echo 'active';}?>">
                            <i class="nav-icon fas fa-clock"></i><p>Activity Log</p>
                        </a>
                    </li>
                    <?php if ($acc['acc_role'] == 'Super Admin') { ?>
                    <!-- Backup -->
                    <li class="nav-item">
                        <a href="/admin/backup_restore" class="nav-link <?php if ($curPageName == 'backup_restore.php'){ echo 'active';}?>">
                            <i class="nav-icon fas fa-hdd"></i><p>Backup/Restore</p>
                        </a>
                    </li>
                    <?php } ?>
                    <!-- Settings -->
                    <li class="nav-item">
                        <a href="/admin/settings" class="nav-link <?php if ($curPageName == 'settings.php'){ echo 'active';}?>">
                            <i class="nav-icon fas fa-cog"></i><p>Settings</p>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</aside>