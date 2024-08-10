<?php
$servername = "localhost";
$username = "root"; // Cambia según tu configuración de MySQL
$password = ""; // Cambia según tu configuración de MySQL
$dbname = "reservas"; // Nombre de la base de datos que acabas de crear

// Crear conexión usando MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$cantidad_personas = $_POST['cantidad_personas'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];

// Escapar caracteres especiales para evitar la inyección SQL (opcional, pero recomendado)
$apellido = mysqli_real_escape_string($conn, $apellido);
$telefono = mysqli_real_escape_string($conn, $telefono);
$cantidad_personas = mysqli_real_escape_string($conn, $cantidad_personas);
$fecha = mysqli_real_escape_string($conn, $fecha);
$hora = mysqli_real_escape_string($conn, $hora);

// Preparar la consulta SQL para insertar los datos
$sql = "INSERT INTO reservas (apellido, telefono, cantidad_personas, fecha, hora)
        VALUES ('$apellido', '$telefono', '$cantidad_personas', '$fecha', '$hora')";

// Ejecutar la consulta y verificar
if ($conn->query($sql) === TRUE) {
    echo "Reserva guardada correctamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
