const selectBtn = document.querySelector(".select-btn"),
      items = document.querySelectorAll(".item"),
      allBtn = document.querySelector(".allBtn");

selectBtn.addEventListener("click", () => {
    selectBtn.classList.toggle("open");
});


items.forEach(item => {
    item.addEventListener("click", () => {
        item.classList.toggle("checked");
        checkAll();
        ukrywanie();

    });
})

function checkAll(){

var wszystkieSprawdzone = true;

  items.forEach(function(item) 
  {
    if (!item.classList.contains("checked")) 
    {
      wszystkieSprawdzone = false;
    }
  });

  if (wszystkieSprawdzone) 
  {
    if(!allBtn.classList.contains("checked"))
    {
      allBtn.classList.toggle("checked");
    }

  } 
  else
  {
    if(allBtn.classList.contains("checked"))
    {
      allBtn.classList.toggle("checked");
    }
  }
}

function zaznacz(){
  allBtn.classList.toggle("checked");
  if(allBtn.classList.contains("checked")){
    items.forEach(function(item) {
      if (!item.classList.contains("checked")) {
        item.classList.toggle("checked");
      }});
  }else{
    items.forEach(function(item) {
      if (item.classList.contains("checked")) {
        item.classList.toggle("checked");
      }});
  }
  ukrywanie();
}

function ukrywanie(){
  items.forEach(function(item) {
    if (!item.classList.contains("checked")) {
        styl = "display:none;"
    }
    else
    {
        styl = "display:block;"
    }
    document.getElementById(item.value).style = styl;
    setCookie(item.value,styl,365);
    
  });
}

function dane(){
  for (let i = 1; i <= items.length; i++) {
    document.getElementById(i).style = getCookie(i);
    if(getCookie(i) == "display:none"){
      items[i-1].classList.toggle("checked");
    }
  }
  checkAll();

}


function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}


