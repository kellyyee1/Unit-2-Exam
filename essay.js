"use strict";

window.addEventListener("load", function () {
    var addBtn = document.getElementById("add");
    var textarea = document.getElementById("paragraph");
    var essayBody = document.getElementById("essay_body");

    addBtn.addEventListener("click", function () {
        var text = textarea.value;

        // Only add if there is text
        if (text.trim() === "") return;

        // Create a new paragraph element with the text
        var p = document.createElement("p");
        p.textContent = text;

        // Append to essay body
        essayBody.appendChild(p);

        // Clear the textarea
        textarea.value = "";
        textarea.focus();
    });
});