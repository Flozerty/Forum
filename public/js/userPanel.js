const navRight = document.querySelector('#nav-right');
const headerNavList = navRight.querySelector('#headerNavList');
const caret = navRight.querySelector('#userPanelShow');

show = false;

caret.addEventListener('click', () => {
  if (show) {
    caret.classList.remove("rotate180");
    headerNavList.style.top = "-300%";
  } else {
    caret.classList.add("rotate180");
    headerNavList.style.top = "150%";
  }
  show = !show;
})