<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">
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
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'add_chores.php' ? 'active' : ''; ?>"
                           href="add_chores.php">Add Chores</a>
                    </li>
                </ul>

                <!-- Profile Dropdown -->
                <ul class="navbar-nav">
                    <li class="nav-item dropdown position-relative">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://www.svgrepo.com/show/335455/profile-default.svg" alt="User profile picture"
                                 width="30" height="30" class="rounded-circle me-2" aria-label="Profile picture">
                            My Profile
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="profile.php">View Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
