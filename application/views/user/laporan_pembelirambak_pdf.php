<html>
<head>
  <title>Data Pembeli</title>
  <style type="text/css">
    #outtable{
      padding: 20px;
      border:1px solid #e3e3e3;
      width:600px;
      border-radius: 5px;
    }

    .short{
      width: 50px;
    }

    .normal{
      width: 150px;
    }

    table{
      border-collapse: collapse;
      font-family: arial;
      color:#5E5B5C;
    }

    thead th{
      text-align: left;
      padding: 10px;
    }

    tbody td{
      border-top: 1px solid #e3e3e3;
      padding: 10px;
    }

    tbody tr:nth-child(even){
      background: #F6F5FA;
    }

    tbody tr:hover{
      background: #EAE9F5
    }
  </style>
</head>
<body>
  <h1 style="text-align: center;">DATA PEMBELI</h1>
	<div id="outtable">
	  <table>
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
	  		</tr>
	  	</thead>
	  	<tbody>
	  		<?php $i = 1; ?>
	  		<?php foreach($rambak as $r): ?>
	  		  <tr>
            <th scope="row"><?php echo $i; ?></th>
            <td><?php echo $r['nama']; ?></td>
            <td><?php echo $r['rambak']; ?></td>
            <td><?php echo $r['gadung']; ?></td>
            <td><?php echo $r['tenggiri']; ?></td>
            <td><?php echo $r['rengginang']; ?></td>
            <td><?php echo $r['total']; ?></td>
            <td><?php if ($r['status']== 1) {
              echo "Belum lunas";
            }else {
              echo "Lunas";
            }; ?></td>
            <td><?php echo $r['keterangan']; ?></td>
	  		  </tr>
	  		<?php $i++; ?>
	  		<?php endforeach; ?>
	  	</tbody>
	  </table>
	 </div>
</body>
</html>
