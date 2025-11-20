<?php 
class GetHead{
    public function headShow($rutaHome, $rutaFormulario){
        ?>
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../../asset/css/bootstrap-5.3.3/css/bootstrap.min.css">
                <link rel="stylesheet" href="../../asset/css/fontawesome-6/css/all.min.css">
                <link rel="stylesheet" href="../../asset/css/<?=$rutaHome?>">
                <link rel="stylesheet" href="../../asset/css/<?=$rutaFormulario?>">
                <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet"> 
                <script src="../../asset/css/bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>
                <link rel="icon" href="data:,">
                <title>Home</title>
            </head>
            <!-- SweetAlert2 -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php
    }
}

?>