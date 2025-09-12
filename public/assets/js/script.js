const imgs = document.querySelectorAll('.header-slider ul img');
const prev_button = document.querySelector('.control-prev');
const next_button = document.querySelector('.control-next');

let n = 0;

function changeSlider() {
  for (let i = 0; i < imgs.length; i++) {
    imgs[i].style.display = 'none';
  }
  imgs[n].style.display = 'block';
}

changeSlider();

prev_button.addEventListener('click', (e) => {
  e.preventDefault();
  if (n > 0) {
    n--;
  } else {
    n = imgs.length - 1;
  }
  changeSlider();
})

next_button.addEventListener('click', (e) => {
  e.preventDefault();
  if (n < imgs.length - 1) {
    n++;
  } else {
    n = 0;
  }
  changeSlider();
})

const scollerContainer = document.querySelectorAll('.products');
for (const item of scollerContainer) { 
item.addEventListener('wheel', (evt) => { 
  evt.preventDefault(); 
  item.scrollLeft += evt.deltaY; 
}) 
}