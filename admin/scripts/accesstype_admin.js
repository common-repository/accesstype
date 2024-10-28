function accesstypeChangeTab(evt, elementId) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("accesstype-tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("accesstype-tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(elementId).style.display = "block";
  evt.currentTarget.className += " active";
}

window.addEventListener('load', hideAccesstypeVisibility, false);

function hideAccesstypeVisibility() {
  // hide accesstype_visibility from custom fields list
  var accesstypeVisibility = document.querySelector("input[value=accesstype_visibility]")
  if(accesstypeVisibility && accesstypeVisibility.closest("tr"))
    accesstypeVisibility.closest("tr").style.display = "none";

  // hide accesstype_visibility from add new custom field select box
  var customFieldSelectbox = document.getElementById('metakeyselect');
  if(customFieldSelectbox) {
    for (i=0;i<customFieldSelectbox.length;  i++) {
     if (customFieldSelectbox.options[i].value=='accesstype_visibility')
       customFieldSelectbox.remove(i);
    }
  }
}

function clickCollapse() {   
  document.getElementsByClassName('accesstype-additional-settings-content')[0].classList.add('accesstype-hidden')
  document.getElementsByClassName('accesstype-up')[0].classList.add('accesstype-hidden')
  document.getElementsByClassName('accesstype-down')[0].classList.remove('accesstype-hidden')   
}

function clickExpand() {
  document.getElementsByClassName('accesstype-additional-settings-content')[0].classList.remove('accesstype-hidden')               
  document.getElementsByClassName('accesstype-up')[0].classList.remove('accesstype-hidden')
  document.getElementsByClassName('accesstype-down')[0].classList.add('accesstype-hidden')
}