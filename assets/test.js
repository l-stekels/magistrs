/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/test.css';
import BMWalker from './js/bmwalker.js';
import P5 from 'p5';

const bmWalker = new BMWalker();

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
const decrementInterval = setInterval(() => {
  number += 0.1;
  number = Number(number.toFixed(2));
  bmWalker.happiness = number;
  if (number >= 6) {
    clearInterval(decrementInterval);
  }
}, 600);
