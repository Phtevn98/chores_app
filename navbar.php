<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/index.php">
            Chores App <i class="fa-solid fa-hands-bubbles ms-1" aria-hidden="true"></i>
            <span class="visually-hidden">Chores App Icon</span>
        </a>

        <button class="navbar-toggler px-3 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <?php if (isset($_SESSION['user_id'])): ?>
                <ul class="navbar-nav me-auto">
                    <?php if (!empty($_SESSION['is_site_admin'])): ?>
                        <!-- Admin Panel Dropdown with horizontal grid -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-shield-lock me-1"></i>
                                <?= htmlspecialchars($lang['admin_panel'] ?? 'Admin Panel') ?>
                            </a>
                            <div class="dropdown-menu p-3" aria-labelledby="adminDropdown" style="min-width: 340px;">
                                <!-- User Management Group -->
                                <h6 class="dropdown-header"><?= htmlspecialchars($lang['user_management'] ?? 'User Management') ?></h6>
                                <div class="row gx-2 mb-2">
                                    <div class="col-6">
                                        <a class="dropdown-item text-center" href="/create_user.php"><?= htmlspecialchars($lang['create_user'] ?? 'Create User') ?></a>
                                    </div>
                                    <div class="col-6">
                                        <a class="dropdown-item text-center" href="/admin/user_list.php"><?= htmlspecialchars($lang['manage_users'] ?? 'Manage Users') ?></a>
                                    </div>
                                </div>
                                <hr class="dropdown-divider">
                                <!-- Chore Management Group -->
                                <h6 class="dropdown-header"><?= htmlspecialchars($lang['chore_management'] ?? 'Chore Management') ?></h6>
                                <div class="row gx-2 mb-2">
                                    <div class="col-6">
                                        <a class="dropdown-item text-center" href="/add_chores.php"><?= htmlspecialchars($lang['add_chore'] ?? 'Add Chore') ?></a>
                                    </div>
                                    <div class="col-6">
                                        <a class="dropdown-item text-center" href="/admin/chore_list.php"><?= htmlspecialchars($lang['manage_chores'] ?? 'Manage Chores') ?></a>
                                    </div>
                                </div>
                                <hr class="dropdown-divider">
                                <!-- Site Config Group -->
                                <h6 class="dropdown-header"><?= htmlspecialchars($lang['site_configuration'] ?? 'Site Configuration') ?></h6>
                                <div class="row gx-2">
                                    <div class="col-6">
                                        <a class="dropdown-item text-center" href="/admin/site_config.php"><?= htmlspecialchars($lang['site_config'] ?? 'Site Config') ?></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>

                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown position-relative">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://www.svgrepo.com/show/335455/profile-default.svg" alt="User profile picture"
                                 width="30" height="30" class="rounded-circle me-2" aria-label="Profile picture">
                            <?= htmlspecialchars($lang['profile'] ?? 'My Profile') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/profile.php"><?= htmlspecialchars($lang['view_profile'] ?? 'View Profile') ?></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout.php"><?= htmlspecialchars($lang['logout'] ?? 'Logout') ?></a></li>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
