<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD2. Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <?php include 'menu.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div>
                <form class="mb-5" method="post" action="nueva.php">
                    <div class="mb-3"> <br>
                        <label class="form-label">Título de la tarea</label>
                        <input class="form-control">
                    </div>
                    <br><br>
                    Estado:
                    <br>
                    <select class="form-select">
                        <option>Pendiente</option>
                        <option>En proceso</option>
                        <option>Completado</option>
                    </select>
                    <br><br>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label><br>
                        <textarea></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>  
              </div>
            </main>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>