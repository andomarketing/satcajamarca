
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PR</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Declaración Tributaria</h1>
            </div>
        </div>

        <form action="#" id="consultarPR">
            <div class="row align-items-center">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="codigo">Código  </label>
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
                <div id="contPR">
                    <img src="../img/pr.png" alt="PR" class="img img-fluid">
                    <div class="items"> <!-- DATOS DE DB --> </div>
                    <table id="datosPR">
                        <tbody>
                            <!-- DATOS DE DB -->
                        </tbody>
                    </table>

                    <table id="datosRelacionados">
                        <tbody>
                            <!-- DATOS DE DB -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="../js/funciones.js"></script>
</body>
</html>

    