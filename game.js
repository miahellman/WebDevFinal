let button = document.getElementById("nextButton");
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
let starSound = new Audio("sounds/success.mp3");
let asteroidSound = new Audio("sounds/lose.mp3");
let currentPlanet = -1;
let finalScore = 0;

let title = document.getElementById("top");
let bottom = document.getElementById("bottom");
let planetImg = document.getElementById("planetImage");
let ships = document.getElementById("spaceships");

function changePlanet() {
    currentPlanet++;

    if (currentPlanet >= planets.length) {
        title.innerHTML = "Tour Complete!";
        title.innerHTML += "\nYou visited all planets!";
        bottom.innerHTML = "Final score is: " + finalScore;
        planetImg.style.display = "none";
        ships.innerHTML = "";
        button.style.display = "none";
        return;
    }

    title.innerHTML = planets[currentPlanet].name;
    planetImg.src = planets[currentPlanet].image;
    planetImg.style.display = "block";
    bottom.innerHTML = "Find the star under one of the ships!";

    ships.innerHTML = "";

    let starPos = parseInt(Math.random() * 5);

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
            if (i == starPos) {
                starSound.play();
                ship.src = "gameImages/star.webp";
                finalScore++;
                
            }
            else {
                asteroidSound.play();
                ship.src = "gameImages/asteroid.png";
            }
        })
        locked = false;
        ships.appendChild(ship);

    }

   

}
button.addEventListener("click", changePlanet);


