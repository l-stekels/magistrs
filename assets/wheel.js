import './styles/wheel.css';

import GEW from "@psychological-components/gew/umd/gew.js";
import "@psychological-components/gew/lib/theme-core.css";
import "@psychological-components/gew/lib/theme-rainbow.css";

const overlay = document.getElementById("overlay");

const gew = GEW.default({
  isMobile: false,
  element: "#wheel",
  R: 80,
  maxElements: 2,
  showLines: true,
  showBorder: true,
  headerTop: 'nekas',
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
  overlay.style.display = 'block';
  console.log(data);
});

const action = gew.elementClick();

action.subscribe(data => {
  overlay.style.display = 'block';
  gew.isActive = false;
  console.log(data);
});
