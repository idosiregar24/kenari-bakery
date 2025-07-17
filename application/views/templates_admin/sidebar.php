<!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <!-- Nav Item - User Information -->



            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url('admin/dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menu
            </div>

            <!-- Nav Item - Tables -->
             
            <!-- Sidebar Menu Items -->
<li class="nav-item">
  <a class="nav-link d-flex align-items-center" href="<?= site_url('admin/data_barang') ?>">
    <i class="fas fa-box fa-fw mr-2"></i>
    <span>Kelola Produk</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link d-flex align-items-center" href="<?= base_url('admin/invoices') ?>">
    <i class="fas fa-file-invoice fa-fw mr-2"></i>
    <span>Invoices</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link d-flex align-items-center" href="<?= base_url('admin/data_pesanan') ?>">
    <i class="fas fa-table fa-fw mr-2"></i>
    <span>Pesanan Masuk</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link d-flex align-items-center" href="<?= base_url('admin/pesanan_diterima') ?>">
    <i class="fas fa-check-circle fa-fw mr-2"></i>
    <span>Pesanan Diterima</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link d-flex align-items-center" href="<?= base_url('admin/daftar_feedback') ?>">
    <i class="fas fa-star fa-fw mr-2"></i>
    <span>Data Feedback</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link d-flex align-items-center" href="<?= base_url('admin/pesanan_dibatalkan') ?>">
    <i class="fas fa-ban fa-fw mr-2"></i>
    <span>Pesanan Dibatalkan</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link d-flex align-items-center" href="<?= base_url('admin/produksi') ?>">
    <i class="fas fa-industry fa-fw mr-2"></i>
    <span>Produksi</span>
  </a>
</li>

    

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
<form class="form-inline" method="get" action="<?= site_url('admin/search') ?>">
    <div class="input-group">
        <input type="text" name="keyword" class="form-control bg-light border-0 small"
               placeholder="Cari pesanan..." aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
</form>





                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
  <!-- ✅ Tombol Logout -->
<a class="dropdown-item" href="<?= base_url('auth/logout') ?>" data-toggle="modal" data-target="#logoutModal">
  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
  Logout
</a>


                    </ul>
                </nav>
                <!-- End of Topbar -->