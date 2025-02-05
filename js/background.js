"use strict";
document.addEventListener('DOMContentLoaded', () => {
    const interBubble = document.querySelector('.interactive');
    if (!interBubble) {
        console.error("Element with class 'interactive' not found.");
        return;
    }
    
    let curX = 0;
    let curY = 0;
    let tgX = 0;
    let tgY = 0;
    let speed = 20;
    let isFirstMove = true;

    //Take mouse position
    tgX = curX = window.event?.clientX || window.innerWidth / 2;
    tgY = curY = window.event?.clientY || window.innerHeight / 2;

    function move() {
        if (isFirstMove && tgX !== 0 && tgY !== 0) {
            curX = tgX;
            curY = tgY;
            isFirstMove = false;
        }

        const dx = tgX - curX;
        const dy = tgY - curY;
        const distance = Math.sqrt(dx * dx + dy * dy);
        
        speed = Math.max(10, Math.min(20, distance / 50));

        curX += dx / speed;
        curY += dy / speed;
        
        interBubble.style.transform = `translate(${Math.round(curX)}px, ${Math.round(curY)}px)`;
        requestAnimationFrame(() => {
            move();
        });
    }

    window.addEventListener('mousemove', (event) => {
        tgX = event.clientX;
        tgY = event.clientY;
    });

    //Add ready class when JS is loaded
    requestAnimationFrame(() => {
        interBubble.classList.add('ready');
    });
    
    move();
});
