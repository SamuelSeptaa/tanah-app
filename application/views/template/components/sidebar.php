<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item <?= ($controller == 'dashboard') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('dashboard') ?>">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item <?= ($controller == 'tanah' || $controller == 'pemilik') ? 'active' : '' ?>">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Data</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse <?= ($controller == 'tanah' || $controller == 'pemilik') ? 'show' : '' ?>" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('tanah') ?>">Tanah</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('pemilik') ?>">Pemilik</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item <?= ($controller == 'user') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= base_url('user') ?>">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">User List</span>
            </a>
        </li>
    </ul>
</nav>
<!-- partial -->