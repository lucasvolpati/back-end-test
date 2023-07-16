<?php
    require __DIR__ . "/../../vendor/autoload.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APi CEP</title>

    <!-- DATATABLE -->
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-1.13.5/datatables.min.css" rel="stylesheet"/>


    <link rel="stylesheet" href="<?= assets('css/main.css') ?>">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <div class="row mt-3" id="form-content">
                <div class="col-lg-8">
                    <h1 class="text-center mb-3">CONSULTAR HISTÓRICO!</h1>
                    <form id="form">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Informe seu e-mail</label>
                        </div>

                        <div class="text-center">
                            <button class="search-btn" id="submit-btn"><i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </form>
                    
                </div>
            </div>

            <div class="row mt-5" id="table-content">
                <div class="col-lg-8">
                    <table id="principal_table" class="table table-hover">

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?= assets('js/jquery.js') ?>"></script>

    <!-- BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/860f00444a.js" crossorigin="anonymous"></script>

    <!-- SWEET ALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DATATABLE -->
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-1.13.5/datatables.min.js"></script>

    <!-- App Scripts -->
    <script src="<?= assets('js/app.js') ?>"></script>
</body>
</html>
