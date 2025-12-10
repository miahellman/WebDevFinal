let button = document.getElementById("nextButton");

// Declare array with all the planet names and their corresponding image links.
let planets = [
    {name: "Mercury", image: "gameImages/mercury.png"}, 
    {name: "Venus", image: "gameImages/venus.png"}, 
    {name: "Earth", image: "gameImages/earth.png"}, 
    {name: "Mars", image: "gameImages/mars.png"}, 
    {name: "Jupiter", image: "gameImages/jupiter.png"}, 
    {name: "Saturn", image: "gameImages/saturn.png"}, 
    {name: "Uranus", image: "gameImages/uranus.png"}, 
    {name: "Neptune", image: "gameImages/neptune.png"}, ];

let locked = false;

// Add audio/sound effects
let starSound = new Audio("sounds/success.mp3");
let asteroidSound = new Audio("sounds/lose.mp3");
let currentPlanet = -1;
let finalScore;
let shootingStar = false;
let timeLeft = 30;
let timer = null;

// Set up the timer 
let timerShow = document.getElementById("timer");
timerShow.innerHTML = "";

// Load saved score from local storage. 
if (localStorage.getItem("finalScore") != null) {
    finalScore = Number(localStorage.getItem("finalScore"));
}
else {
    finalScore = 0;
}

let title = document.getElementById("top");
let bottom = document.getElementById("bottom");
let planetImg = document.getElementById("planetImage");
let ships = document.getElementById("spaceships");

function startTime() {
    clearInterval(timer);
    timeLeft = 30;
    timerShow.innerHTML = `Time left: ${timeLeft}s`;

    timer = setInterval(() => {
        timeLeft--;
        timerShow.innerHTML = `Time left: ${timeLeft}s`;
        if (timeLeft <= 0) {
            clearInterval(timer);
            locked = true;
            bottom.innerHTML = "Time's up!  You missed the chance to find the star!";
            button.disabled = false;
        }
    }, 1000)
}

// Reset game when the user starts over. 
function reset() {
    button.innerHTML = "Next";
    currentPlanet = -1;
    title.innerHTML = "Welcome Back to Our Outer Space Tour!";
    bottom.innerHTML = "Travel from planet to planet and find the hidden star. Each round there will be 5 spaceships. Under one, is the star... or the shooting star! Find the correct ship and get a point. Score carries over between rounds. ";
    planetImg.style.display = "none";
    ships.innerHTML = "";
}

// Rotate between planets. 
function changePlanet() {
    startTime(); 
    currentPlanet++;

    // Display an end screen when the user rotates through all the planets
    if (currentPlanet >= planets.length) {
        title.innerHTML = "Tour Complete!";
        title.innerHTML += "\nYou visited all planets!";
        bottom.innerHTML = "Final score is: " + finalScore;
        button.innerHTML = "Restart";
        planetImg.style.display = "none";
        ships.innerHTML = "";
        currentPlanet = -1;
        clearInterval(timer);
        timerShow.innerHTML = "";

        return;
    }

    title.innerHTML = planets[currentPlanet].name;
    planetImg.src = planets[currentPlanet].image;
    planetImg.style.display = "block";
    let starPos = parseInt(Math.random() * 5);

    if (shootingStar) {
        bottom.innerHTML = "Find the star... or a shooting star!!!"
    }
    else {
        bottom.innerHTML = "Find the star under one of the ships!";
    }
    
    let shootingStarIndex = -1;

    if (shootingStar) {
        shootingStarIndex = parseInt(Math.random() * 5);

        if (shootingStarIndex === starPos) {
            shootingStarIndex = (starPos + 1) % 5;
        }
        shootingStar = false;
    }
    ships.innerHTML = "";

    

    for (let i = 0; i < 5; i++) {
        let ship = document.createElement("img");
        ship.src = "gameImages/spaceship.png";
        ship.classList.add("shipImg");
        ship.addEventListener("click", function() {
            if (locked == true) {
                return;
            }
            else {
                locked = true;
            }

            if (shootingStarIndex != -1 && i === shootingStarIndex) {
                starSound.currentTime = 0;
                starSound.play();
                ship.src = "gameImages/shootingstar.png";
                finalScore = finalScore + 3;
                localStorage.setItem("finalScore", finalScore);
            }
            else if (i == starPos) {
                starSound.currentTime = 0;
                shootingStar = true;
                starSound.play();
                ship.src = "gameImages/star.webp";
                finalScore++;
                localStorage.setItem("finalScore", finalScore);
                
            }
            else {
                asteroidSound.currentTime = 0;
                asteroidSound.play();
                ship.src = "gameImages/asteroid.png";
            }
        })
        locked = false;
        ships.appendChild(ship);

    }

}

button.addEventListener("click", function() {
    if (button.innerHTML == "Restart") {
        reset();
    }
    else {
        changePlanet();
    }
});


