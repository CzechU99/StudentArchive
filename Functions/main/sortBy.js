$(document).ready(function () {
  var rotatingClockwise = true;
  var sortDirections = {
    name: true,
    size: true,
    extension: true
  };

  function sortTable(dataAttribute, isNumeric, sortKey, table) {
    var  rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    switching = true;
    dir = sortDirections[sortKey] ? "asc" : "desc";

    while (switching) {
      switching = false;
      rows = table.querySelectorAll(".file-row");

      for (i = 0; i < (rows.length - 1); i++) {
        shouldSwitch = false;
        x = rows[i].getAttribute(dataAttribute);
        y = rows[i + 1].getAttribute(dataAttribute);

        if (isNumeric) {
          x = parseFloat(x);
          y = parseFloat(y);
        } else {
          x = x.toLowerCase();
          y = y.toLowerCase();
        }

        if (dir == "asc") {
          if (x > y) {
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (x < y) {
            shouldSwitch = true;
            break;
          }
        }
      }

      if (shouldSwitch) {
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        switchcount++;
      } else {
        if (switchcount == 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }
  }

  document.getElementById('sortByFolders').addEventListener('click', function () {
    var icon = this.querySelector('i');

    if (rotatingClockwise) {
      icon.classList.remove('fa-sort-alpha-down');
      icon.classList.add('fa-sort-alpha-up');
    } else {
      icon.classList.remove('fa-sort-alpha-up');
      icon.classList.add('fa-sort-alpha-down');
    }

    rotatingClockwise = !rotatingClockwise;

    icon.classList.remove('spin-animation');
    setTimeout(function () {
      icon.classList.add('spin-animation');
    }, 10);

    var subjectsDivs = document.querySelectorAll(".Subject");

    var container = document.getElementById("contentBottom");
    var divy = Array.from(container.querySelectorAll(".Subject"));


    function sortItems() {
      var odwroconaTablica = divy.reverse();

      odwroconaTablica.forEach(function (div) {
        container.appendChild(div);
      });
    }

    sortItems();
  });

  document.getElementById('sortByFiles').addEventListener('click', function () {
    var icon = this.querySelector('i');

    if (rotatingClockwise) {
      icon.classList.remove('fa-sort-alpha-down');
      icon.classList.add('fa-sort-alpha-up');
    } else {
      icon.classList.remove('fa-sort-alpha-up');
      icon.classList.add('fa-sort-alpha-down');
    }

    rotatingClockwise = !rotatingClockwise;

    icon.classList.remove('spin-animation');
    setTimeout(function () {
      icon.classList.add('spin-animation');
    }, 10);


    tables = document.querySelectorAll('.filesTable');


    for (i = 0; i < tables.length; i++) {
      table = tables[i];
      switching = true;

      sortTable("data-name", false, 'name', table)

    }
  });
})


