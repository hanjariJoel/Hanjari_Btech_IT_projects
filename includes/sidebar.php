<div class="sidebar">

    <div class="logo">

        <h3>
            <i class="fa-solid fa-music"></i>
            <span>Hanjari's Music House</span>
        </h3>

        <p>Stock Maintenance System</p>

    </div>

    <ul>

        <li>
            <a href="/hanjari_music_house/dashboard/dashboard.php">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="/hanjari_music_house/instruments/index.php">
                <i class="fa-solid fa-drum"></i>
                <span>Instruments</span>
            </a>
        </li>

        <li>
            <a href="/hanjari_music_house/categories/index.php">
                <i class="fa-solid fa-folder"></i>
                <span>Categories</span>
            </a>
        </li>

        <li>
            <a href="/hanjari_music_house/suppliers/index.php">
                <i class="fa-solid fa-truck"></i>
                <span>Suppliers</span>
            </a>
        </li>

        <li>
            <a href="/hanjari_music_house/stock/stock_in.php">
                <i class="fa-solid fa-arrow-down"></i>
                <span>Stock In</span>
            </a>
        </li>

        <li>
            <a href="/hanjari_music_house/stock/stock_out.php">
                <i class="fa-solid fa-arrow-up"></i>
                <span>Stock Out</span>
            </a>
        </li>

        <li>
            <a href="/hanjari_music_house/reports/index.php">
                <i class="fa-solid fa-chart-column"></i>
                <span>Reports</span>
            </a>
        </li>
        <?php echo $_SESSION['role']; ?>
        <?php if (isset($_SESSION['role']) && strtolower($_SESSION['role']) === 'administrator'): ?>

        <li>
            <a href="/hanjari_music_house/admin/users/add_user.php">
                <i class="fa-solid fa-users-gear"></i>
                <span>User Management</span>
            </a>
        </li>

        <?php endif; ?>

        <li>
            <a href="/hanjari_music_house/profile/index.php">
                <i class="fa-solid fa-user"></i>
                <span>Profile</span>
            </a>
        </li>

        <li>
            <a href="/hanjari_music_house/auth/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>

    <hr>

    <div class="support">

        <h6>Need Help?</h6>

        <p>
            <i class="fa-solid fa-phone"></i>
            +254 740 704 619
        </p>

        <p>
            <i class="fa-solid fa-envelope"></i>
            support@hanjarimusic.co.ke
        </p>

    </div>

</div>