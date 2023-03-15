const slideDown = (element) => {
  const slideOpenDirector = document.getElementById("slideOpenDirector");
  if (slideOpenDirector.className == "fa-solid fa-chevron-right") {
    slideOpenDirector.className = "fa-solid fa-chevron-down";
    element.parentElement.style.alignItems = "flex-start";
    element.parentElement.style.alignContent = "flex-start";
    element.parentElement.lastElementChild.style.display = "block";
    element.parentElement.style.height = "auto";
    // liFunctions(element, 1)
  } else {
    slideOpenDirector.className = "fa-solid fa-chevron-right";
    element.parentElement.lastElementChild.style.display = "none";
    // liFunctions(element, 0)
  }
};

const liFunctions = (element, status) => {
  let li = element.lastElementChild.children;
  if (status == 1) {
    for (let i = 0; i < li.length; i++) {
      const liDisplay = () => {
        li[i].style.display = "flex";
      };

      setInterval(liDisplay, 80 + i * 50);
    }
  } else if (status == 0) {
    for (let j = 0; j < li.length; j++) {
      li[i].style.display = "none";
    }
  }
};
