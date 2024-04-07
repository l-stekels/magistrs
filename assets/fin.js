import Chart from 'chart.js/auto';

// Your data
let guesses = [
  { time: 2342, correct: true },
  { time: 5034, correct: false },
  { time: 3405, correct: false },
  // ... more data ...
];

// Current user's guess
let currentGuess = { time: 3533, correct: true };

// Filter the guesses into correct and incorrect arrays
let correctGuesses = guesses.filter(guess => guess.correct);
let incorrectGuesses = guesses.filter(guess => !guess.correct);

// Calculate the average time for correct and incorrect guesses
let averageCorrectTime = correctGuesses.reduce((sum, guess) => sum + guess.time, 0) / correctGuesses.length;
let averageIncorrectTime = incorrectGuesses.reduce((sum, guess) => sum + guess.time, 0) / incorrectGuesses.length;

// Create the chart
let ctx = document.getElementById('chart').getContext('2d');
let chart = new Chart(ctx, {
  type: 'radar',
  data: {
    labels: ['Pareizie minējumi', 'Kļūdainie minējumi', 'Jūsu minējums'],
    datasets: [
      {
        label: 'Vidējais minējums laiks (ms)',
        data: [averageCorrectTime, averageIncorrectTime, currentGuess.time],
        backgroundColor: 'rgba(5,224,189,0.1)', // Light blue
        borderColor: 'rgb(5,224,189)', // Light blue
        pointBackgroundColor: 'blue'
      }
    ]
  },
  options: {
    responsive: true,
    scales: {
      r: {
        beginAtZero: true,
        title: {
          display: true,
          text: 'Time (ms)'
        }
      }
    }
  }
});
