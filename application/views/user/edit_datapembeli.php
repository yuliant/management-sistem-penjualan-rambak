<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

          <!-- edit nama dan gambar user -->
          <div class="row">
            <div class="col-lg-8">

              <!-- form tambah data menu -->
              <form class="" action="" method="post">
                <input type="hidden" name="id" value="<?php echo $rambak['id']; ?>">
                <div class="form-group row">
                  <label for="nama" class="col-sm-3 col-form-label">Nama Pembeli</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $rambak['nama']; ?>">
                    <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="rambak" class="col-sm-3 col-form-label">Jumlah Rambak</label>
                  <div class="col-sm-10">
                      <input type="number" class="form-control" id="rambak" name="rambak" value="<?= $rambak['rambak']; ?>">
                      <?= form_error('rambak', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group row">
                  <label for="gadung" class="col-sm-3 col-form-label">Jumlah Gadung</label>
                  <div class="col-sm-10">
                      <input type="number" class="form-control" id="gadung" name="gadung" value="<?= $rambak['gadung']; ?>">
                      <?= form_error('gadung', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group row">
                  <label for="tenggiri" class="col-sm-3 col-form-label">Jumlah Tenggiri</label>
                  <div class="col-sm-10">
                      <input type="number" class="form-control" id="tenggiri" name="tenggiri" value="<?= $rambak['tenggiri']; ?>">
                      <?= form_error('tenggiri', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group row">
                  <label for="rengginang" class="col-sm-3 col-form-label">Jumlah Rengginang</label>
                  <div class="col-sm-10">
                      <input type="number" class="form-control" id="rengginang" name="rengginang" value="<?= $rambak['rengginang']; ?>">
                      <?= form_error('rengginang', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group row">
                  <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                  <div class="col-sm-10">
                      <textarea type="text" class="form-control" id="keterangan" name="keterangan" value=""><?= $rambak['keterangan']; ?></textarea>
                      <?= form_error('keterangan', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group row" style="text-align:right;">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-lg btn-primary" name="editJualrambak">Edit</button>
                  </div>
                </div>

              </form>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
