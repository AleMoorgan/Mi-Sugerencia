<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $opcion = isset($_POST['opcion']) ? intval($_POST['opcion']) : 0;

    $archivo = "votos/votos_" . $id . ".txt";

    // Inicializar si no existe
    if (!file_exists($archivo)) {
        file_put_contents($archivo, "0|0");
    }

    list($si, $no) = explode("|", file_get_contents($archivo));

    if ($opcion === 1) {
        $si++;
    } elseif ($opcion === 2) {
        $no++;
    }

    file_put_contents($archivo, "$si|$no");

    echo json_encode(['si' => $si, 'no' => $no]);
}
?>