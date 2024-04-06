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

gew.otherEmotion.onSave.subscribe(data => {
  // overlay.style.display = 'block';
  console.log(data);
});

let previouslySelected = null;
const svg = gew.mainElement;
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
});
