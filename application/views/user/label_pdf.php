<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Cetak Label</title>

    <style>
    .card {
      border:solid 3px black;
      transition: 0.3s;
      width: 40%;
      margin-bottom: 3px;
      page-break-inside: avoid;
    }

    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    .container {
      padding: 6px;
    }
    p{
      margin: 2;
      padding: 2;
    }
    </style>

  </head>
  <body>
    <?php foreach($rambak as $r): ?>
    <div class="card">
      <div class="container">
        <h2 style="text-align:center;"><b><?php echo $r['nama']; ?></b></h2>
        <p>Jumlah Rambak : <?php echo $r['rambak']; ?> buah</p>
        <p>Jumlah Gadung : <?php echo $r['gadung']; ?> buah</p>
        <p>Jumlah Tenggiri : <?php echo $r['tenggiri']; ?> buah</p>
        <p>Jumlah Rengginang : <?php echo $r['rengginang']; ?> buah</p>
        <p>Total : <?php echo $r['total']; ?> </p>
        <p>Keterangan : <?php echo $r['keterangan']; ?> </p>
      </div>
    </div>
    <?php endforeach; ?>

  </body>
</html>
