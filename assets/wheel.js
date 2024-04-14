import GEW from "@psychological-components/gew/umd/gew.js";
import "@psychological-components/gew/lib/theme-rainbow.css";
import './styles/wheel.css';

const overlay = document.getElementById("overlay");

const gew = GEW.default({
  isMobile: false,
  element: "#wheel",
  R: 80,
  maxElements: 3,
  showLines: true,
  showBorder: true,
  headerTop: 'nav emociju',
  headerBottom: 'cits',
  labels: [
    "interese",
    "uzjautrinājums",
    "lepnums",
    "prieks",
    "bauda",
    "apmierinājums",
    "mīlestība",
    "apbrīna",
    "atvieglojums",
    "līdzjūtība",
    "skumjas",
    "vaina",
    "nožēla",
    "kauns",
    "vilšanās",
    "bailes",
    "riebums",
    "nicinājums",
    "naids",
    "dusmas"
  ],
  radiusX: 5000,
});

const promtSaveButton = document.getElementsByClassName('save_btn')[0];
const promtCancelButton = document.getElementsByClassName('cancel_btn')[0];
promtSaveButton.innerHTML = 'Saglabāt';
promtCancelButton.innerHTML = 'Atcelt';
const form = document.getElementById('wheel-form');
let emotionInput = document.querySelector('input[name="emotion"]');
let intensityInput = document.querySelector('input[name="intensity"]');
let customEmotionInput = document.querySelector('input[name="custom-emotion"]');

// Cita emocija
gew.otherEmotion.onSave.subscribe(data => {
  // overlay.style.display = 'block';
  customEmotionInput.value = data;
  emotionInput.value = '';
  intensityInput.value = '';
  form.submit();
});


const svg = gew.mainElement;
// // Padara apli melnbaltu

// // Iezīmē visus aplīšus
const circles = svg.querySelectorAll('circle');
// Iet cauri visiem un noņem pildījumu un uzliek melnu kontūru
circles.forEach(circle => {
  // izņemot vidējam
  if (circle.classList.contains('line_border')) {
    return;
  }
  circle.style.fill = 'rgba(177,178,178,0)'; // Remove the fill
  circle.style.stroke = 'rgb(0,0,0)'; // Set the stroke color to black
});

// Nav emociju izvēle
// let aElements = svg.getElementsByTagName('a');
// let links = [];
// for(let i = 0; i < aElements.length; i++) {
//   if(!aElements[i].classList.value.startsWith('row_')) {
//     links.push(aElements[i]);
//   }
// }
// links[0].addEventListener('click', (e) => {
//   intensityInput.value = '';
//   customEmotionInput.value = '';
//   emotionInput.value = '';
//   form.submit();
// });

let previouslySelected = [];
gew.elementClick().subscribe(data => {
  // if ([] !== previouslySelected) {
  //   previouslySelected.forEach(e => {
  //     e.style.fill = 'rgba(177,178,178,0)'; // Remove the fill
  //     e.style.stroke = 'rgb(0,0,0)'; // Set the stroke color to black
  //   })
  //   previouslySelected = [];
  // }
  // TODO: fix this
  const selectedIndex = data.findIndex(e => e !== null);
  if (selectedIndex === -1) {
    return;
  }
  console.log(selectedIndex);
  const selected = data[selectedIndex];

  const selectedRow = svg.querySelector(`.line_${selectedIndex + 1}`);
  const selectedElement = selectedRow.querySelector(`.row_${selected}`);
  selectedElement.children[0].style = null;
  previouslySelected.push(selectedElement.children[0]);

  const emotion = data.findIndex(e => e !== null);
  const intensity = data[emotion];
  emotionInput.value = emotion;
  intensityInput.value = intensity + 1; //0-based index
  customEmotionInput.value = '';
});
