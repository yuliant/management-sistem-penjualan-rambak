<!-- Begin Page Content -->
  <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

      <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Rambak</div>
                  <div class="h4 mb-0 font-weight-bold text-gray-800"><?php echo $total_rambak; ?> Buah </div>
                  <!-- Divider -->
                  <hr class="sidebar-divider mb-1 mt-1">
                  <div class="h6 mb-0 text-gray-800">Total : Rp. <?php echo $total_rambak * $harga_rambak; ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Gadung</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_gadung; ?> Buah</div>
                  <!-- Divider -->
                  <hr class="sidebar-divider mb-1 mt-1">
                  <div class="h6 mb-0 text-gray-800">Total : Rp. <?php echo $total_gadung * $harga_gadung; ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Tenggiri</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_tenggiri; ?> Buah</div>
                  <!-- Divider -->
                  <hr class="sidebar-divider mb-1 mt-1">
                  <div class="h6 mb-0 text-gray-800">Total : Rp. <?php echo $total_tenggiri * $harga_tenggiri; ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Rengginang</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_rengginang; ?> Buah</div>
                  <!-- Divider -->
                  <hr class="sidebar-divider mb-1 mt-1">
                  <div class="h6 mb-0 text-gray-800">Total : Rp. <?php echo $total_rengginang * $harga_rengginang; ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="row">

        <div class="col-lg-6">

          <!-- Basic Card Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Pendapatan</h6>
            </div>
            <div class="card-body">
              <div class="col mr-2">
                <div class="h2 mb-0 font-weight-bold text-gray-800">Rp. <?php echo $total_pendapatan; ?></div>
                <!-- Divider -->
                <hr class="sidebar-divider mb-1 mt-1">
                <div class="h6 mb-0 text-gray-800">Dari dijualnya <?php echo $total_rambak + $total_gadung + $total_tenggiri + $total_rengginang; ?> barang</div>
              </div>
            </div>
          </div>

        </div>

      </div>

  </div>
  <!-- /.container-fluid -->

</div>
