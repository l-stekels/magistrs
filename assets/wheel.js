import GEW from "@psychological-components/gew/umd/gew.js";
import "@psychological-components/gew/lib/theme-rainbow.css";
import './styles/wheel.css';

const gew = GEW.default({
  isMobile: false,
  element: "#wheel",
  R: 80,
  maxElements: 3,
  showLines: true,
  showBorder: true,
  headerTop: 'nav emociju',
  headerBottom: 'cits',
  labels: wheelEmotions,
  radiusX: 5000,
});

const promtSaveButton = document.getElementsByClassName('save_btn')[0];
const promtCancelButton = document.getElementsByClassName('cancel_btn')[0];
promtSaveButton.innerHTML = 'Saglabāt';
promtCancelButton.innerHTML = 'Atcelt';
const form = document.getElementById('wheel-form');
let emotionInput = document.querySelector('input[name="emotion"]');
let customEmotionInput = document.querySelector('input[name="custom-emotion"]');

// Cita emocija
gew.otherEmotion.onSave.subscribe(data => {
  customEmotionInput.value = data;
  emotionInput.value = JSON.stringify([]);
  form.submit();
});
// Izvēlēta emocija vai neitrālas emocijas
gew.elementClick().subscribe(data => {
  customEmotionInput.value = '';
  emotionInput.value = JSON.stringify(data);
});
