<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
        <div class="sidebar-brand-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Student System</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="/admin">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Menu</div>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/mahasiswa') ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Mahasiswa</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/about">
            <i class="fas fa-fw fa-info-circle"></i>
            <span>About</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/contact">
            <i class="fas fa-fw fa-envelope"></i>
            <span>Contact</span>
        </a>
    </li>
    
    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>