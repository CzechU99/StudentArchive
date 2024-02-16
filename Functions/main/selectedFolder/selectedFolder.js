document.addEventListener('DOMContentLoaded', function () {
  // Pobierz wszystkie elementy o klasie 'clickableDiv'
  var divs = document.getElementsByClassName('semesterFolder');

  // Dodaj obsługę kliknięcia dla każdego diva
  for (var i = 0; i < divs.length; i++) {
    divs[i].addEventListener('click', function () {
      //removePreviousSelected;

      // Pobierz id klikniętego diva
      var divId = this.id;

      localStorage.setItem('selectedDivId', divId);

      // Wywołaj funkcję PHP za pomocą AJAX, aby zaktualizować zmienną sesji
      updateSessionVariable(divId);
    });

    var selectedDivId = localStorage.getItem('selectedDivId');
    if (selectedDivId) {
        var selectedDiv = document.getElementById(selectedDivId);
        if (selectedDiv) {
            selectedDiv.classList.add('activeFolder');
        }
    }
  }
});

function removePreviousSelected() {
  var divs = document.getElementsByClassName('activeFolder');

  for (var i = 0; i < divs.length; i++) {
    divs[i].classList.remove('activeFolder');
  }
}


function updateSessionVariable(divId) {
  var xhr = new XMLHttpRequest();

  xhr.open('POST', 'Functions/main/selectedFolder/selectedFolder.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  var data = 'divId=' + divId;

  xhr.onload = function () {
    location.reload();
  };

  xhr.send(data);
}