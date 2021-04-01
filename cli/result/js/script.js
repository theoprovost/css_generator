const el = document.querySelector(".sprite");
const btnNext = document.querySelector("#btn_next");
const btnBefore = document.querySelector("#btn_before");

// Nav for every frame of the sprite
let n = 1;

btnNext.addEventListener("click", (e) => {
  e.preventDefault();

  // NB: the var t is provided by PHP : it reprents the total number of individual elements of the sprite
  if (n < t) {
    n++;
    el.id = `img${n}`;
  }
});

btnBefore.addEventListener("click", (e) => {
  e.preventDefault();

  if (n > 1) {
    n--;
  }
  el.id = `img${n}`;
});
