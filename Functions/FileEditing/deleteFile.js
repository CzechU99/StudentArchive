function deleteFile(element) {
  // Pobierz ścieżkę pliku
  var elementPath = element.getAttribute('data-file-path');
  var elementType = element.getAttribute('data-type')
  var sender = element.type;
  var descriptionFile = element.getAttribute('data-description');

  var userConfirmation;

  if (sender != 'checkbox') {
    userConfirmation = confirm("Czy na pewno chcesz usunąć " + (elementType === 'folder' ? 'folder' : 'plik') + "?");
  } else {
    userConfirmation = true;
  }

  if (userConfirmation) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'Functions/FileEditing/deleteFile.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          logEvent("Usunięcie " + (elementType === 'folder' ? 'folderu, wraz z plikami' : 'pliku'), "Pomyślne", elementPath);
          console.log(xhr.responseText);
          location.reload();
        } else {
          logEvent("Usunięcie " + (elementType === 'folder' ? 'folderu, wraz z plikami' : 'pliku'), "Błąd", elementPath);
          console.error('Błąd podczas żądania:', xhr.status);
        }
      }
    };

    var data = 'path=' + encodeURIComponent(elementPath) + '&folder=' + (elementType === 'folder' ? 'true' : 'false') + '&description=' + encodeURIComponent(descriptionFile);

    xhr.send(data);
  } else {
    logEvent("Usunięcie " + (elementType === 'folder' ? 'folderu, wraz z plikami' : 'pliku'), "Przerwano", elementPath);
  }
}

function usunPliki(element) {
  var folderName = element.dataset.folderName;
  var filesToDelete = document.querySelectorAll("." + folderName);

  userConfirmation = confirm("Czy na pewno chcesz usunąć wybrane elementy");

  if (userConfirmation) {
    filesToDelete.forEach(function (fileToDelete) {
      if (fileToDelete.checked) {
        deleteFile(fileToDelete);
      }
    });
  }
}

function multiDelete(element) {
  var folderName = element.dataset.folderName;
  var filesToDelete = document.querySelectorAll("." + folderName);
  console.log(folderName);
  var deleteFilesButton = document.getElementById('deleteFilesBtn_' + folderName);

  var isHidden = filesToDelete[0].classList.contains('hidden');

  if (!isHidden) {
    for (var i = 0; i < filesToDelete.length; i++) {
      filesToDelete[i].classList.add('hidden');
    }
    deleteFilesButton.classList.add('hidden');
  } else {
    for (var i = 0; i < filesToDelete.length; i++) {
      filesToDelete[i].classList.remove('hidden');
    }
    deleteFilesButton.classList.remove('hidden');
  }

}

function moveFile(element, editMode) {
  var elementName = element.getAttribute('data-file-name');
  var elementPath = element.getAttribute('data-file-path');
  var targetPath = element.getAttribute('data-file-target');
  var selectedAccess = $('input[name="access"]:checked').val();

  if (selectedAccess) {
    $.ajax({
      url: "Functions/FileEditing/moveFileFunc.php",
      method: 'POST',
      data: {
        fileName: elementName,
        filePath: elementPath,
        fileTarget: targetPath,
        accessType: selectedAccess,
        editMode: editMode
      },
      success: function () {
        location.reload();

        const newFileLoc = removeBeforePenultimateSlash(targetPath);
        editMode = editMode.charAt(0).toUpperCase() + editMode.slice(1);
        logEvent(editMode + " pliku", editMode + " pliku do /" + newFileLoc + "/" + selectedAccess, elementPath);
      }
    });
  } else {
    alert("Nie wybrano czy plik ma być prywatny/publiczny");
  }

}

function openPopup(sender, semestr_id, element) {
  var popupId = 'popupDiv';
  var elementName = element.getAttribute('data-file-name');
  var elementPath = element.getAttribute('data-file-path');
  var targetPath = element.getAttribute('data-file-target');
  var editMode = element.getAttribute('data-mode');

  if ($('#' + popupId).length !== 0) {
    document.body.removeChild(popupDiv);
    $('#' + popupId).remove();
  }

  if (semestr_id) {
    currentFolderNumber = semestr_id;
  } else {
    currentFolderNumber = 1;
  }

  $.ajax({
    url: "Functions/FileEditing/moveFilePopUp.php",
    method: 'POST',
    data: {
      target: sender,
      currentFolder: currentFolderNumber,
      filePath: elementPath,
      fileTarget: targetPath,
      fileName: elementName,
      editMode: editMode
    },
    success: function (data) {
      var popupDiv = $('<div>', {
        id: popupId,
        html: data,
        css: {
          backgroundColor: '#f0f0f0',
          border: '1px solid #ccc',
          position: 'fixed',
          top: '50%',
          left: '50%',
          transform: 'translate(-50%, -50%)',
          zIndex: '999'
        }
      });

      $('body').append(popupDiv);
    },
    error: function (xhr, status, error) {
      console.error('Błąd pobierania danych z PHP:', status, error);
      console.error('Szczegóły błędu:', xhr.responseText);
    }
  });
}

function closePopup() {
  var popupId = 'popupDiv';
  document.body.removeChild(popupDiv);
  $('#' + popupId).remove();
}

function logEvent(eventType, eventDetails, fileName) {
  let lastSlashIndex = fileName.lastIndexOf('/');
  fileName = fileName.substring(lastSlashIndex + 1);

  const eventInfo = {
    type: eventType,
    details: eventDetails,
    fileName: fileName,
    timestamp: new Date().toISOString()
  }


  fetch("Functions/main/logActionRegister.php", {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(eventInfo),
  })
    .then(response => response.json())
    .then(data => console.log(data))
    .catch((error) => console.error('Error:', error));
}

function removeBeforePenultimateSlash(str) {
  const parts = str.split('/');
  if (parts.length < 3) {
    return str;
  }
  return parts.slice(-2).join('/');
}



