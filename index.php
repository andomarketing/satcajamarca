<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/estilos.css">
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Declaración Tributaria</h1>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-12 col-sm-12">
                <table class="table table-hover" id="tabla_personas">
                    <thead>
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Nombres y Apellidos</th>
                            <th scope="col">DNI</th>
                            <th scope="col" class="text-center">Impreso</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DATOS OBTENIDOS POR JS -->
                    </tbody>
                </table>

                <hr>
                <div class="row">
                    <div class="col-12 col-sm-12 ">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination" id="paginacion_personas">
                                
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="/js/funciones.js"></script>

    <script>
        obtener_personas(1);
    </script>
</body>
</html>