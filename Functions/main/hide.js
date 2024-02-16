document.addEventListener("DOMContentLoaded", function() {
  var toggleDivs = document.querySelectorAll(".toggleDiv");

  if (toggleDivs.length > 0) {
    toggleDivs.forEach(function(div) {
      div.addEventListener("click", function() {
        var element = this.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling;
        element.classList.toggle("hidden");
      });
    });
  } else {
    console.error("No elements with class 'toggleDiv' found.");
  }

  var toggleDivs = document.querySelectorAll(".hideFolder");

  if (toggleDivs.length > 0) {
    toggleDivs.forEach(function(div) {
      div.addEventListener("click", function() {
        var element = this.nextElementSibling.nextElementSibling;
        element.classList.toggle("hidden");
      });
    });
  } else {
    console.error("No elements with class 'toggleDiv' found.");
  }
  var toggleDivs = document.querySelectorAll(".toggleSearchDiv");

  if (toggleDivs.length > 0) {
    toggleDivs.forEach(function(div) {
      div.addEventListener("click", function() {
        var element = this.nextElementSibling.nextElementSibling;
        element.classList.toggle("hidden");
      });
    });
  } else {
    console.error("No elements with class 'toggleSearchDiv' found.");
  }

  var toggleDivs = document.querySelectorAll(".hideFolderSearch");

  if (toggleDivs.length > 0) {
    toggleDivs.forEach(function(div) {
      div.addEventListener("click", function() {
        var element = this.nextElementSibling.nextElementSibling;
        element.classList.toggle("hidden");
      });
    });
  } else {
    console.error("No elements with class 'hideFolderSearch' found.");
  }
});

