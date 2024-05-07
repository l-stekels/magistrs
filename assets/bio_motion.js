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
let walkerStarted = false;
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
    if (!walkerStarted && isEyeTracking) {
      // Zīmē krustu
      p.stroke(255);
      p.strokeWeight(5);
      // Vertikālā krustā līnija
      p.line(width() / 2, height() / 2 - 50, width() / 2, height() / 2 + 50);
      // Horizontālā krusta līnija
      p.line(width() / 2 - 50, height() / 2, width() / 2 + 50, height() / 2);
      return;
    }
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

  const timeout = isEyeTracking ? 3000 : 0;
  setTimeout(() => {
    walkerStarted = true;
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
  }, timeout);
});

const sadButton = document.getElementById('bio_motion_bedigs');
const happyButton = document.getElementById('bio_motion_priecigs');
const guessedInput = document.getElementById('bio_motion_guessedEmotion');

const buttonClickHandler = (e) => {
  bmWalker.setSpeed(0);
  const elapsedTime = Date.now() - time;
  switch (e.target.id) {
    case 'bio_motion_bedigs':
      guessedInput.value = 'sad';
      break;
    case 'bio_motion_priecigs':
      guessedInput.value = 'happy';
      break;
    default:
      guessedInput.value = '';
      break;
  }
  const thresholdInput = document.getElementById('bio_motion_threshold');
  thresholdInput.value = elapsedTime;
  const debugTimeContainer = document.getElementById('debug-time');
  if (null !== debugTimeContainer) {
    debugTimeContainer.textContent = `Time: ${elapsedTime}ms`;
  }
  e.target.form.submit();
}
sadButton.addEventListener('click', buttonClickHandler);
happyButton.addEventListener('click', buttonClickHandler);
