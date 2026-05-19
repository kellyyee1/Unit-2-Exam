"use strict";

window.addEventListener("load", function () {
    var headsCount = 0;
    var tailsCount = 0;

    var flipBtn = document.getElementById("flip");
    var coinImg = document.getElementById("coin");
    var numHeads = document.getElementById("num_heads");
    var numTails = document.getElementById("num_tails");

    flipBtn.addEventListener("click", function () {
        // 50/50 probability
        var isHeads = Math.random() < 0.5;

        if (isHeads) {
            coinImg.src = "heads.jpg";
            coinImg.alt = "Heads";
            headsCount++;
            numHeads.textContent = headsCount;
        } else {
            coinImg.src = "tails.jpg";
            coinImg.alt = "Tails";
            tailsCount++;
            numTails.textContent = tailsCount;
        }
    });
});