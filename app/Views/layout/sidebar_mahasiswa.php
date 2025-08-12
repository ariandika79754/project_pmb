<ul class="menu-inner py-1">
    <!-- Dashboards -->
    <?php $request = service('request'); ?>
    <li class="menu-item <?= ($request->uri->getSegment(2) === 'dashboard') ? 'active' : '' ?>">

        <a href="/mahasiswa/dashboard" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Dashboards">Dashboard</div>
        </a>

    </li>

    <li class="menu-item <?= ($request->uri->getSegment(2) === 'profile') ? 'active' : '' ?>">
        <a href="/mahasiswa/profile" class="menu-link">
            <i class="menu-icon tf-icons bx bxs-user-pin"></i>
            <div data-i18n="">Profil</div>
        </a>
    </li>

    

</ul>