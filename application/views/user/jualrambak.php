<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

    <div class="row">
      <div class="col-lg">

        <div class="row mt-3 mb-3">
          <div class="col-md-6">
            <form class="" action="<?php echo base_url('user/cari_pembeli'); ?>" method="post">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari Data Pembeli.." name="keyword">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="submit">Cari</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- validation error -->
        <?php if (validation_errors()): ?>
          <div class="alert alert-danger" role="alert">
            <?php echo validation_errors(); ?>
          </div>
        <?php endif; ?>

        <?php if (empty($rambak)) : ?>
          <div class="alert alert-danger" role="alert">
            Data Pembeli tidak ditemukan
          </div>
        <?php endif ?>

        <!-- flashdata message -->
        <?php echo $this->session->flashdata('message'); ?>

        <!-- tombol tambah menu terhubung dengan modal-->
        <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">Add new data</a>
        <a href="<?php echo base_url('user/cetak_pdf'); ?>" target="_blank" class="btn btn-warning mb-3">Download Laporan</a>
        <a href="<?php echo base_url('user/cetak_label'); ?>" target="_blank" class="btn btn-success mb-3">Download Label</a>
        <!-- Table -->
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nama</th>
              <th scope="col">Rambak</th>
              <th scope="col">Gadung</th>
              <th scope="col">Tenggiri</th>
              <th scope="col">Rengginang</th>
              <th scope="col">Total</th>
              <th scope="col">Status</th>
              <th scope="col">Keterangan</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 1;
            foreach ($rambak as $r) : ?>
            <tr>
              <!-- tidak urut sesuai table mysql, tidak apa2 -->
              <th scope="row"><?php echo $i; ?></th>
              <td><?php echo $r['nama']; ?></td>
              <td><?php echo $r['rambak']; ?></td>
              <td><?php echo $r['gadung']; ?></td>
              <td><?php echo $r['tenggiri']; ?></td>
              <td><?php echo $r['rengginang']; ?></td>
              <td style="text-align:right;"><?php echo $r['total']; ?></td>
              <td><?php if ($r['status']== 1) {
                echo "Belum lunas";
              }else {
                echo "Lunas";
              }; ?></td>
              <td><?php echo $r['keterangan']; ?></td>
              <td>
                <a class="badge badge-success" href="<?php echo base_url('user/editJualrambak/') . $r['id']; ?>">edit</a>
                <a class="badge badge-warning" href="<?php echo base_url('user/changestatus/') . $r['id'] .('/'). $r['status'];?>">Status</a>
                <a class="badge badge-danger" href="<?php echo base_url('user/deleteJualrambak/') . $r['id']; ?>" onclick="return confirm('yakin?');">delete</a>
              </td>
            </tr>
          <?php
            $i++;
            endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
  <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- modal tambah data menu -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new data pembeli</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- form tambah data menu -->
      <form class="" action="<?php echo base_url('user/jualrambak'); ?>" method="post">
          <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama">
            </div>
            <div class="form-group">
              <input type="number" class="form-control" id="rambak" name="rambak" placeholder="Jumlah rambak">
            </div>
            <div class="form-group">
              <input type="number" class="form-control" id="gadung" name="gadung" placeholder="Jumlah gadung">
            </div>
            <div class="form-group">
              <input type="number" class="form-control" id="tenggiri" name="tenggiri" placeholder="Jumlah tenggiri">
            </div>
            <div class="form-group">
              <input type="number" class="form-control" id="rengginang" name="rengginang" placeholder="Jumlah rengginang">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="keterangan">
            </div>
            <div class="form-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" name="status" id="status" checked>
                <label class="form-check-label" for="status">
                  Belum lunas?
                </label>
              </div>
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </form>

    </div>
  </div>
</div>
