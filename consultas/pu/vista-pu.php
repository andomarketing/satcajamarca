
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PU</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
    <div class="container no_imprimir" style="max-width: 665px;
    overflow: hidden;     padding: 35px;">
        <div class="row">
            <div class="col-12">
                <h1 class="no_imprimir">Declaración Tributaria  </h1>
            </div>
        </div>

        <form action="#" id="consultarPU" class="no_imprimir">
            <div class="row align-items-center">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="codigo">Código</label>
                        <input type="text" name="codigo" id="codigo" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-12">
                <div id="dtsPU">

                </div>
            </div>
        </div>

        <div class="row" class="no_imprimir">
            <div class="col-12 col-sm-12">
                <button onclick="javascript:window.print()" class="btn btn-success no_imprimir">Imprimir</button>
            </div>
        </div>
    </div>


    <!-- TABLA -->

    <table class="table table-bordered tabla_pu" style="background-image:  url('../../img/pu.png');
    background-size: cover;
background-repeat: no-repeat;
    " >
	<tbody>
		<tr style="height: 113px;">
			<td>  <p class="emular">LOGO SAT </p></td>
			<td>  <p class="emular"> PU </p></td>
			
		</tr>
		<tr>
            <td class="center" colspan="2"> <p class="emular"> DECLARACION JUARADA MECANIZADA DEL IMPUESTO PREDIAL </p>
            <p class="emular"> XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX </p>
            <p class="emular">DECLARACION JUARADA N <span class="dato">54554</span>  </p>
            </td>
			
		</tr >
		<tr>
			<td><p class="emular dato_predio_pu">Datos del predio: <span class="dato">XXXXX </span></p></td>
			<td><p class="emular"> emision: <span class="dato emision_pu">445333  </span></p></td>
		
		</tr>
		<tr>
			<td colspan="2">
                 <p class="emular"> CODIGO CONTRIBUYENTE:<span class="dato codigo_contribuyente_pu">31684</span></p>
                 <p class="emular"> NOMBRE: <span class="dato nombre_pu">EL WAYNER</span></p>
                 <p class="emular"> CODIGO PREDIO: <span class="dato codigo_predio_pu">23344</span></p>
                 <p class="emular"> DIRECCION DEL PREDIOO:<span class="dato direccion_predio_pu">AV Arequipa centro comercial la casnona 134</span></p>
                 <p class="emular"> LUGAR: <span class="dato lugar_pu">xxxx</span></p>
                 <p class="emular"> SECTOR: <span class="dato sector_pu">AS</span></p>
                
            </td>
			
			
        </tr>
        
      
	
	</tbody>
</table>
<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="../../js/funciones.js"></script>
</body>
</html>

    