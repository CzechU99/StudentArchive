var popoverBody =
  `<div>
  <input type="checkbox" id="extensionCheckbox" class="filterChkbx" onchange="hello()">
  <label style="vertical-align: text-bottom;" for="extensionCheckbox"><b>Rozszerzenie:</b></label>
  <input type="text" id="extensionInput" class="form-control" placeholder="Wprowadź rozszerzenie">
  </div>
  </br>
  <div>
  <input style="vertical-align: text-bottom;" type="checkbox" id="sizeCheckbox">
  <label class="form-check-label" for="sizeCheckbox"><b>Rozmiar (kb): </b></label>
  </br>
  <input type="radio" id="greaterThanRadio" name=comparisonType value="greaterThan" checked>
  <label style="vertical-align: text-bottom;" class="form-check-label" for="higherThanRadio">Większe/Równe</label>
  </br>
  <input type="radio" id="lessThanRadio" name=comparisonType value="lessThan">
  <label style="vertical-align: text-bottom;" class="form-check-label" for="lowerThanRadio">Mniejsze</label>
  <input type="number" id="sizeInput" class="form-control" placeholder="Wprowadź rozmiar">
  </div>
  </br>
  <div>
  <input type="checkbox" id="nameCheckbox">
  <label style="vertical-align: text-bottom;" for="nameCheckbox"><b>Nazwa pliku:</b></label>
  <input type="text" id="nameInput" class="form-control" placeholder="Wprowadź nazwę">
</div>`

$(document).ready(function () {
  $('#filtersBtn').popover({
    content: function () {
      return popoverBody;
    },
    html: true,
    trigger: 'click',
    placement: 'top',
    sanitize: false
  });

  document.getElementById("filtersBtn").addEventListener("click", showFilters);
});

function showFilters() {
  document.getElementById("extensionCheckbox").addEventListener("change", filterItems);
  document.getElementById("sizeCheckbox").addEventListener("change", filterItems);
  document.getElementById("nameCheckbox").addEventListener("change", filterItems);
  document.getElementById("extensionInput").addEventListener("input", filterItems);
  document.getElementById("sizeInput").addEventListener("input", filterItems);
  document.getElementById("nameInput").addEventListener("input", filterItems);
  document.getElementById("greaterThanRadio").addEventListener("change", filterItems);
  document.getElementById("lessThanRadio").addEventListener("change", filterItems);

}

function filterItems() {
  var extensionFilter = document.getElementById("extensionCheckbox").checked;
  var sizeFilter = document.getElementById("sizeCheckbox").checked;
  var comparison = document.querySelector('input[name="comparisonType"]:checked').value;
  var nameFilter = document.getElementById("nameCheckbox").checked;

  var extensionValue = document.getElementById("extensionInput").value.toLowerCase();
  var sizeValue = document.getElementById("sizeInput").value;
  var nameValue = document.getElementById("nameInput").value.toLowerCase();

  var items = document.querySelectorAll('.file-row');



  items.forEach(function (item) {
    extensionCondition = item.getAttribute('data-extension').toLowerCase().includes(extensionValue);

    if (comparison == "greaterThan") {
      sizeCondition = parseInt(item.getAttribute('data-size')) >= sizeValue;
    } else {
      sizeCondition = parseInt(item.getAttribute('data-size')) < sizeValue;
    }


    nameCondition = item.getAttribute('data-name').toLowerCase().includes(nameValue);

    if (extensionFilter && !extensionCondition) {
      item.classList.add('extension-filter');
    } else if (item.classList.contains('extension-filter')) {
      item.classList.remove('extension-filter');
    }

    if (sizeFilter && !sizeCondition) {
      item.classList.add('size-filter');
    } else if (item.classList.contains('size-filter')) {
      item.classList.remove('size-filter');
    }

    if (nameFilter && !nameCondition) {
      item.classList.add('name-filter');
    } else if (item.classList.contains('name-filter')) {
      item.classList.remove('name-filter');
    }
  });
}







