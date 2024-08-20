const board = document.getElementById('board');
const cells = document.querySelectorAll('.cell');
const restartButton = document.getElementById('restartButton');

let currentPlayer = 'X';
let boardState = Array(9).fill(null);
let isGameActive = true;

const winningCombinations = [
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    [0, 4, 8],
    [2, 4, 6]
];

function handleCellClick(event) {
    const cell = event.target;
    const cellIndex = cell.getAttribute('data-index');

    if (boardState[cellIndex] !== null || !isGameActive) {
        return;
    }

    cell.textContent = currentPlayer;
    boardState[cellIndex] = currentPlayer;

    if (checkWin()) {
        alert(`Jogador ${currentPlayer} venceu!`);
        isGameActive = false;
    } else if (boardState.every(cell => cell !== null)) {
        alert('Empate!');
        isGameActive = false;
    } else {
        currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
    }
}

function checkWin() {
    return winningCombinations.some(combination => {
        return combination.every(index => {
            return boardState[index] === currentPlayer;
        });
    });
}

function restartGame() {
    currentPlayer = 'X';
    boardState.fill(null);
    isGameActive = true;
    cells.forEach(cell => (cell.textContent = ''));
}

cells.forEach(cell => cell.addEventListener('click', handleCellClick));
restartButton.addEventListener('click', restartGame);
