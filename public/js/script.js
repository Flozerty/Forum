const createForm = document.querySelector('#createForm');
const addButton = document.querySelectorAll('.addButton');

addButton.forEach(button => {
  button.addEventListener("click", () => {
    createForm.style.display = "flex"
  })
})
