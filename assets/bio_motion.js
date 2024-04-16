/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/bio_motion.css';
import BMWalker from 'bmwalker';
import P5 from 'p5';

const bmWalker = new BMWalker();

bmWalker.setSpeed(0);
new P5((p) => {
  const width = () => p.windowWidth / 2;
  const height = () => p.windowHeight / 2;
  p.setup = () => {
    let canvas = p.createCanvas(width(), height());
    canvas.parent('canvas-container');
    p.background(0);
  };
  p.windowResized = () => {
    p.resizeCanvas(width(), height());
  };
  p.draw = () => {
    const markers = bmWalker.getMarkers(height());
    // Novieto centrā
    p.translate(width() / 2, height() / 2);
    // Melna fona krāsa
    p.background(0);
    // Punktu krāsa balta
    p.stroke(255);
    // Zīmē punktu katram bmwalker merķierim
    markers.forEach((m, _) => {
      p.circle(m.x, m.y, 5);
    });
  }
});

let number = 0;
const startEmotion = (step) => {
  const changeInterval = setInterval(() => {
    number += step;
    number = Number(number.toFixed(2));
    bmWalker.happiness = number;
    if (number >= 6 || number <= -6) {
      clearInterval(changeInterval);
    }
  }, 100/*ms*/);
};

const startMotionButton = document.getElementById('start-motion');
const overlay = document.getElementById('overlay');
let time = 0;
startMotionButton.addEventListener('click', (e) => {
  e.preventDefault();
  // Novāc overlay
  overlay.style.display = 'none';
  // Figūra sāk soļot
  bmWalker.setSpeed(1);
  // Figūras emocijas mainās
  switch (emotion) {
    case 'happy':
      startEmotion(0.1);
      break;
    case 'sad':
      startEmotion(-0.1);
      break;
    default:
      startEmotion(0);
      break;
  }
  // Sākam laika atskaiti
  time = Date.now();
});

const sadButton = document.getElementById('sad-button');
const happyButton = document.getElementById('happy-button');
const guessedInput = document.getElementById('guessed-emotion');

const buttonClickHandler = (e) => {
  bmWalker.setSpeed(0);
  const elapsedTime = Date.now() - time;
  switch (e.target.id) {
    case 'sad-button':
      guessedInput.value = 'sad';
      break;
    case 'happy-button':
      guessedInput.value = 'happy';
      break;
    default:
      guessedInput.value = '';
      break;
  }
  const thresholdInput = document.getElementById('threshold-input');
  thresholdInput.value = elapsedTime;
  const debugTimeContainer = document.getElementById('debug-time');
  if (null !== debugTimeContainer) {
    debugTimeContainer.textContent = `Time: ${elapsedTime}ms`;
  }
}
sadButton.addEventListener('click', buttonClickHandler);
happyButton.addEventListener('click', buttonClickHandler);
