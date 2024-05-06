const main = document.querySelector("main");
const navRight = document.querySelector('#nav-right');
const userContainer = navRight.querySelector("#userContainer");
const headerNavList = navRight.querySelector('#headerNavList');
const caret = navRight.querySelector('#userPanelShow');


show = false;

userContainer.addEventListener('click', () => {
  if (show) {
    caret.classList.remove("rotate180");
    headerNavList.style.top = "-400%";
  } else {
    caret.classList.add("rotate180");
    headerNavList.style.top = "150%";
  }
  show = !show;
})

main.addEventListener("click", () => {
  if (show) {
    caret.classList.remove("rotate180");
    headerNavList.style.top = "-400%";
    show = !show;
  }
})





