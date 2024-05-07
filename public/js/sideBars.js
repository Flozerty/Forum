const
  sideRight = document.querySelector('#layout-aside'),
  sideLeft = document.querySelector('#sideNav-left'),
  leftButton = sideLeft.querySelector('#toggle-left'),
  rightButton = sideRight.querySelector('#toggle-right');

let
  leftBool = true,
  rightBool = true;

leftButton.addEventListener('click', () => {
  if (leftBool) {
    sideLeft.style.left = 0;
    leftButton.classList.add('rotate180')
  } else {
    sideLeft.style.left = "-250px";
    leftButton.classList.remove('rotate180')
  }
  leftBool = !leftBool
})

rightButton.addEventListener('click', () => {
  if (rightBool) {
    sideRight.style.right = 0;
    rightButton.classList.add('rotate180')
  } else {
    sideRight.style.right = "-250px";
    rightButton.classList.remove('rotate180')
  }
  rightBool = !rightBool
})