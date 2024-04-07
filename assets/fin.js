import Chart from 'chart.js/auto';

// Filter the guesses into correct and incorrect arrays
let correctGuesses = guesses.filter(guess => guess.correct);
let incorrectGuesses = guesses.filter(guess => !guess.correct);

// Calculate the average time for correct and incorrect guesses
let averageCorrectTime = correctGuesses.reduce((sum, guess) => sum + guess.time, 0) / correctGuesses.length;
let averageIncorrectTime = incorrectGuesses.reduce((sum, guess) => sum + guess.time, 0) / incorrectGuesses.length;

// Create the chart
let ctx = document.getElementById('chart').getContext('2d');
let chart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Pareizie minējumi', 'Kļūdainie minējumi', 'Jūsu minējums'],
    datasets: [
      {
        label: ['Pareizie minējumi'],
        data: [averageCorrectTime,  null, null],
        backgroundColor: 'rgba(5,224,189,0.1)',
        borderColor: 'rgb(5,224,189)',
        borderWidth: 1
      },
      {
        label: 'Kļūdainie minējumi',
        data: [null, averageIncorrectTime, null],
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'rgb(255, 99, 132)',
        borderWidth: 1
      },
      {
        label: 'Jūsu minējums',
        data: [null, null, currentGuess.time],
        backgroundColor: 'rgba(255, 159, 64, 0.2)',
        borderColor: 'rgb(255, 159, 64)',
        borderWidth: 1
      },
    ]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
        title: {
          display: true,
          text: 'Laiks (sekundes)'
        }
      }
    }
  }
});
