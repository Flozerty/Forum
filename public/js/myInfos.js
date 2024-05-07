const emailInfos = document.querySelector("#emailInfos");

if (emailInfos) {
  const changeSpan = emailInfos.querySelector("span")

  bool = true;

  changeSpan.addEventListener("click", () => {
    if (bool) {
      input = document.createElement('input')
      input.type = "email"
      input.id = 'email'
      input.name = 'email'
      validateButton = document.createElement("input")
      validateButton.type = "submit"
      validateButton.value = "changer"
      emailInfos.appendChild(input)
      emailInfos.appendChild(validateButton)
      bool = false;
    }
  })
}