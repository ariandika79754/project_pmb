<ul class="menu-inner py-1">
    <?php $request = service('request'); ?>

    <!-- Dashboard -->
    <li class="menu-item <?= ($request->uri->getSegment(2) === 'dashboard') ? 'active' : '' ?>">
        <a href="/admin/dashboard" class="menu-link">
            <i class="menu-icon tf-icons bx bx-grid-alt"></i>
            <div>Dashboard</div>
        </a>
    </li>

    <!-- Profile -->
    <li class="menu-item <?= ($request->uri->getSegment(2) === 'profile') ? 'active' : '' ?>">
        <a href="/admin/profile" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user-circle"></i>
            <div>Profile</div>
        </a>
    </li>

    <!-- Cmshbaru -->
    <li class="menu-item <?= ($request->uri->getSegment(2) === 'cmshbaru') ? 'active' : '' ?>">
        <a href="/admin/cmshbaru" class="menu-link">
            <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
            <div>Cmshbaru</div>
        </a>
    </li>

    <!-- Users -->
    <li class="menu-item <?= ($request->uri->getSegment(2) === 'users') ? 'active' : '' ?>">
        <a href="/admin/users" class="menu-link">
            <i class="menu-icon tf-icons bx bx-group"></i>
            <div>Users</div>
        </a>
    </li>

    <!-- Kode (Jurusan, Prodi, Tahun) -->
    <li class="menu-item <?= (
        $request->uri->getSegment(3) === 'jurusan' ||
        $request->uri->getSegment(3) === 'prodi' ||
        $request->uri->getSegment(3) === 'tahun'
    ) ? 'active open' : '' ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-code-alt"></i>
            <div>Kode</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item <?= ($request->uri->getSegment(3) === 'jurusan') ? 'active' : '' ?>">
                <a href="/admin/kode/jurusan" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-building"></i>
                    <div>Kode Jurusan</div>
                </a>
            </li>
            <li class="menu-item <?= ($request->uri->getSegment(3) === 'prodi') ? 'active' : '' ?>">
                <a href="/admin/kode/prodi" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book-content"></i>
                    <div>Kode Prodi</div>
                </a>
            </li>
            <li class="menu-item <?= ($request->uri->getSegment(3) === 'tahun') ? 'active' : '' ?>">
                <a href="/admin/kode/tahun" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div>Kode Tahun</div>
                </a>
            </li>
        </ul>
    </li>

    <!-- NPM -->
    <li class="menu-item <?= ($request->uri->getSegment(2) === 'npm') ? 'active' : '' ?>">
        <a href="/admin/npm" class="menu-link">
            <i class="menu-icon tf-icons bx bx-id-card"></i>
            <div>NPM</div>
        </a>
    </li>
</ul>
