<?php
include("con_db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (strlen($_POST['name']) >= 1 && strlen($_POST['email']) >= 1 && strlen($_POST['phone']) >= 1 && strlen($_POST['message']) >= 1) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $message = trim($_POST['message']);
        $fechareg = date("d/m/y");

        // Manejo del archivo
        $fileName = "";
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $file = $_FILES['file'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];
            $fileName = $file['name'];

            // Extensiones permitidas
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($fileExt, $allowedExts) && $fileSize <= 10000000) { // Tamaño máximo 10MB
                $newFileName = uniqid('', true) . "." . $fileExt;
                $fileDestination = 'uploads/' . $newFileName;

                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    $fileName = $newFileName; // Actualiza el nombre del archivo en la base de datos
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al subir el archivo']);
                    exit();
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Extensión de archivo no permitida o tamaño demasiado grande']);
                exit();
            }
        }

        $consulta = "INSERT INTO datos(nombre, email, telefono, mensaje, foto, fecha_reg) VALUES ('$name','$email','$phone','$message','$fileName','$fechareg')";
        $resultado = mysqli_query($conex, $consulta);
        if ($resultado) {
            echo json_encode(['status' => 'success', 'message' => '¡Te has inscripto correctamente!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Ups ha ocurrido un error']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => '¡Por favor complete todos los campos!']);
    }
}
?>

