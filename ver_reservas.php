<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root"; // Cambia este dato si tu usuario no es root
$password = ""; // Si tu usuario tiene contraseña, agrégala aquí
$dbname = "reservas"; // Cambia este dato por el nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Eliminar fila si se recibe una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM reservas WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    // Redirigir para evitar reenvío de formulario
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Consulta para obtener los datos
$sql = "SELECT * FROM reservas"; // Cambia "reservas" por el nombre de tu tabla
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas Realizadas</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            background-color: white;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        form {
            margin: 0;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }
    </style>
    <script>
        function confirmarEliminacion() {
            return confirm("¿Está seguro de que desea eliminar esta reserva?");
        }
    </script>
</head>
<body>
    <h1>Reservas Realizadas</h1>
    <table>
        <tr>
            <th>Apellido</th>
            <th>Teléfono</th>
            <th>Número de Invitados</th>
            <th>Fecha de Reserva</th>
            <th>Hora de Reserva</th>
            <th>Acciones</th> <!-- Columna adicional para acciones -->
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Mostrar los datos de cada fila
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['apellido'] . "</td>";
                echo "<td>" . $row['telefono'] . "</td>";
                echo "<td>" . $row['cantidad_personas'] . "</td>";
                echo "<td>" . $row['fecha'] . "</td>";
                echo "<td>" . $row['hora'] . "</td>";
                echo "<td>";
                echo "<form method='POST' action=''>";
                echo "<input type='hidden' name='delete_id' value='" . $row['id'] . "'>";
                echo "<button type='submit' class='delete-btn' onclick='return confirmarEliminacion()'>Eliminar</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay datos disponibles</td></tr>";
        }
        ?>
    </table>
    <a href="index.html">Volver al Formulario</a>
</body>
</html>

<?php
$conn->close();
?>
