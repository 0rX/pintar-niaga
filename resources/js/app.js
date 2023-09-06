import './bootstrap';

let text1 = document.getElementById('parallax-text1');
let text2 = document.getElementById('parallax-text2');
let box1 = document.getElementById('middlebox');
let box2 = document.getElementById('middlebox2');
let text3 = document.getElementById('parallax-text3');
let text4 = document.getElementById('parallax-text4');

window.addEventListener('scroll', () => {
    let valueY = window.scrollY;
    let valueX = 0;

    text1.style.marginRight = valueY * 2.5 + 'px';
    text2.style.marginLeft = valueY * 2.5 + 'px';
    text1.style.marginTop = valueY * -2 + 'px';
    text2.style.marginTop = valueY * -2 + 'px';
    text1.style.opacity = 100 - valueY*1.5 + '%';
    text2.style.opacity = 100 - valueY*1.5 + '%';
    if (valueY < 100) {
        box1.style.fontSize = valueY * 1.5 + 'px';
        box1.style.fontWeight = (valueY/10)*100;
        box1.style.opacity = valueY + '%';
    } else if (valueY > 100) {
        valueX =  valueY - 105;
        box1.style.opacity = 100 - ((valueY-100)*1) + '%';
        box2.style.opacity = -50 + valueX + '%';
    }

});
