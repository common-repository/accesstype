function runAccesstypeUI(f) {
  if (window.accesstypeUI && window.accesstypeUI.loaded) f();
  else (window.accesstypeUIq = window.accesstypeUIq || []).push(arguments);
}