import GEW from "@psychological-components/gew/umd/gew.js";
import "@psychological-components/gew/lib/theme-rainbow.css";
import './styles/wheel.css';

const overlay = document.getElementById("overlay");

const gew = GEW.default({
  isMobile: false,
  element: "#wheel",
  R: 80,
  maxElements: 1,
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

let previouslySelected = null;
const svg = gew.mainElement;

// Nav emociju izvēle
let aElements = svg.getElementsByTagName('a');
let links = [];
for(let i = 0; i < aElements.length; i++) {
  if(!aElements[i].classList.value.startsWith('row_')) {
    links.push(aElements[i]);
  }
}
links[0].addEventListener('click', (e) => {
  intensityInput.value = '';
  customEmotionInput.value = '';
  emotionInput.value = '';
  form.submit();
});

gew.elementClick().subscribe(data => {
  if (null !== previouslySelected) {
    previouslySelected.classList.remove('active');
  }
  const selectedIndex = data.findIndex(e => e !== null);
  if (selectedIndex === -1) {
    previouslySelected = null;
    return;
  }
  const selected = data[selectedIndex];

  const selectedRow = svg.querySelector(`.line_${selectedIndex + 1}`);
  const selectedElement = selectedRow.querySelector(`.row_${selected}`);
  selectedElement.classList.add('active');
  previouslySelected = selectedElement;

  const emotion = data.findIndex(e => e !== null);
  const intensity = data[emotion];
  emotionInput.value = emotion;
  intensityInput.value = intensity + 1;
  customEmotionInput.value = '';
});
