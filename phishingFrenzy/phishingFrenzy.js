let score = 0;
let time = 0;
var emails = null;
var scoreDisplay;
var timeDisplay;
var emailDisplay;
var reportButton;
var startButton
var emailInterval;
const gameTime = 60;
var easy = 3000;
var medium = 2000;
var hard = 1000;
var difficulty;
var gameOverMessage;

var startTime;

scoreDisplay = document.getElementById("scoreDisplay");
timeDisplay = document.getElementById("timeDisplay");
emailDisplay = document.getElementById("emailDisplay");
reportButton = document.getElementById("report_button");
easyButton = document.getElementById("easy");
mediumButton = document.getElementById("medium");
hardButton = document.getElementById("hard");
response = document.getElementById("response");
playGame = document.getElementById('inGame')
difficultySelector = document.getElementById('difficultySelector')
playerMessage = document.getElementById('playerMessage')

easyButton.addEventListener('click', () => {
    startTime = Math.floor(Date.now() / 1000);
    difficulty = easy;
    point = difficulty;
    phishingFrenzy();
    difficultySelector.classList.add('hide');
    playGame.classList.remove('hide');
});

mediumButton.addEventListener('click', () => {
    startTime = Math.floor(Date.now() / 1000);
    difficulty = medium;
    point = difficulty;
    phishingFrenzy();
    difficultySelector.classList.add('hide');
    playGame.classList.remove('hide');
});

hardButton.addEventListener('click', () => {
    startTime = Math.floor(Date.now() / 1000);
    difficulty = hard;
    point = difficulty;
    phishingFrenzy();
    difficultySelector.classList.add('hide');
    playGame.classList.remove('hide');
});

function phishingFrenzy() {

    score = 0;

    function generateEmail() {

        const emailTexts = [
            {
                phishing: false,
                text: "Dear valued customer, we have an exciting offer just for you! Click the link to learn more.",
            },
            {
                phishing: true,
                text: "Your bank account has been frozen! Click this link to verify your identity and unlock your account.",
            },
            {
                phishing: false,
                text: "Hi there, just following up on the proposal we discussed last week. Can you give me a call to discuss further?",
            },
            {
                phishing: true,
                text: "Your Amazon account has been hacked! Click this link to reset your password and secure your account.",
            },
            {
                phishing: false,
                text: "Greetings, I wanted to touch base with you about the project timeline. Are we still on track for the end of the month?",
            },
            {
                phishing: true,
                text: "Your PayPal account has been compromised! Click this link to verify your account information and prevent further damage.",
            },
            {
                phishing: false,
                text: "Hello, please review the attached document and let me know your thoughts. Thank you!",
            },
            {
                phishing: true,
                text: "Your account has been compromised! Click this link to reset your password immediately!",
            },
        ];

        var randomIndex = Math.floor(Math.random() * emailTexts.length)

        const randomText = emailTexts[randomIndex].text;
        const randomphishing = emailTexts[randomIndex].phishing;
        return {
            text: randomText,
            phishing: randomphishing,
        };
    }

    reportButton.addEventListener('click', () => {

        console.log("click");

        if (emails.phishing) {
            score=score+point;
            clearInterval(emailInterval)
            emailInt();
            updateGame();
        }
        else {
            gameOverMessage = "That was a real Email"
            gameOver();
        }
    });

    function updateScoreAndTime() {
        var elapsedTime = Math.floor(Date.now() / 1000) - startTime;
        var timeRemaining = gameTime - elapsedTime;
        if (timeRemaining <= 0) {
            clearInterval(emailInterval);
            clearInterval(timerInterval);
            gameWin();
        }
        scoreDisplay.innerText = score;
        timeDisplay.innerText = timeRemaining;
    }

    function checkEmail() {
        if(emails == null){
            updateGame();
        }
        else if(emails.phishing){
            gameOverMessage = "You have been phished!!!";
            gameOver();
        }
        else{
            score = score + 1000;
            updateGame();
        }    
    }

    function updateGame() {
        clearInterval(pointInterval);
        pointInt();
        point = difficulty;
        emails = generateEmail();
        console.log(emails.phishing);
        emailDisplay.innerText = emails.text

        console.log(emails.text)
        console.log(emails.phishing)
    }

    function gameWin() {
        clearInterval(emailInterval);
        clearInterval(pointInterval);
        clearInterval(timerInterval);
        restartGame();
        playerMessage.innerText = `Congratulations! You've won! Final Score: ${score}`;
    }

    function gameOver() {
        clearInterval(emailInterval);
        clearInterval(pointInterval);
        clearInterval(timerInterval);
        restartGame();
        playerMessage.innerText = gameOverMessage;
    }

    function restartGame() {
        playGame.classList.add('hide');
        difficultySelector.classList.remove('hide')
    }

    let timerInterval = setInterval(updateScoreAndTime, 1000);

    function emailInt() { emailInterval = setInterval(checkEmail, difficulty); }
    emailInt();


    function pointInt() { pointInterval = setInterval(lowerScore, 100); }
    pointInt();

    function lowerScore(){
        point = point - 100;
    }
}
