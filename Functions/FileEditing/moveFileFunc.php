<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sourcePath = $_POST['filePath'];
    $destinationFolder = $_POST['fileTarget'] . '/' . $_POST['accessType'] . '/';
    $fileNameWithExtension = $_POST['fileName'];
    $editMode = $_POST['editMode'];

    $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
    $fileExtension = pathinfo($fileNameWithExtension, PATHINFO_EXTENSION);

    if ($editMode == "kopiowanie") {
        $counter = 1;
        $destinationPath = $destinationFolder . $fileNameWithExtension;

        while (file_exists($destinationPath)) {
            $fileName = $fileName . " (" . $counter . ")";
            $destinationPath = $destinationFolder . $fileName . "." . $fileExtension;
            $counter++;
        }

        if (copy($sourcePath, $destinationPath)) {
            echo json_encode(['success' => true, 'fileName' => $fileName . "." . $fileExtension]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Błąd podczas kopiowania pliku.']);
        }
    } else if ($editMode == "przenoszenie") {
        if (rename($sourcePath, $destinationFolder . $fileNameWithExtension)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Błąd podczas przenoszenia pliku.']);
        }
    }

} else {
    echo json_encode(['success' => false, 'error' => 'Nieprawidłowe żądanie.']);
}
?>