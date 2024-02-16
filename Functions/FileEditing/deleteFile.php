<?php
function deleteFiles($target) {
    if (is_dir($target)) {
        $files = glob($target . '/*', GLOB_MARK);
        foreach ($files as $file) {
            deleteFiles($file);
        }
        rmdir($target);
    } elseif (is_file($target)) {
        unlink($target);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $encodedPath = "../../" . $_POST['path'];
    $isFolder = $_POST['folder'] === 'true';
    $descriptionFile = "../../tagdesc/" . $_POST['description'] . "_opis.txt";

    echo `<script>console.log($descriptionFile)<>`;

    if (unlink($descriptionFile)) {
        echo "Plik został usunięty.";
    } else {
        echo "Błąd podczas usuwania pliku.";
    }

    if ($isFolder) {
        deleteFiles($encodedPath);

        if (rmdir($encodedPath)) {
            echo "Folder został usunięty.";
        } else {
            echo "Błąd podczas usuwania folderu." . $encodedPath;
        }
    } else {
        // Usuń plik
        if (unlink($encodedPath)) {
            echo "Plik został usunięty.";
        } else {
            echo "Błąd podczas usuwania pliku.";
        }
    }
} else {
    echo 'Niedozwolone żądanie.';
}
?>