const createTopicForm = document.querySelector('#createTopicForm');
const addButton = document.querySelectorAll('.addButton');

addButton.forEach(button => {
  button.addEventListener("click", () => {
    createTopicForm.style.display = "flex"
  })
})
