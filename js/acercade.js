// Acerca de

// Hmmmm. What glyphs do we want to use? I usually use cuss words, but I’ll tone it down.
// const glyphs = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
const glyphs = '0123456789';
// Colors? Sure, we can have 5, 3, 11, 666… There’s a lot out there. Have fun with it! (I hate when people say that).
const colors = [ '#f67809', '#faf7db', '#060606' ];
// Choose the main thing to put the stuff in. (The Stuff was a good movie.)
const main = document.querySelector('.acercade');
//const main = document.getElementById('presenta');

/*
    All right now, this is where my brain fails and I feel dumber. We need to decide the number glyphs that get plopped and the font size on the square pixelage, so it's evenly filled when the window is big, small, short, wide and the font isn't HUGE on itty bitty windows or too small on the BIG ones.
*/

// How big is that window?
const width = window.innerWidth;
const height = window.innerHeight;

// We want to know how big the room is in square footage… er, window and square pixelage.
const squarePixelage = width * height;
const ratio = Math.floor(squarePixelage / 40000);
const fillRatio = ratio + 20;

// Give us a random number. We can tell it how high we want to get.
const rand = (max) => Math.floor(Math.random() * max);

// Give the background a random color. I hope it’s a good one.
main.style = '--background-color: ${colors[rand(colors.length)]}; --opacity: ${rand(100) / 100 + 0.1}';

// The main event, plopping glyphs on the page.
function glyphIt(max) {
	// We’re only gonna do this so many times.
	for (let i = 0; i < max; i++) {
		// Let’s get a random glyph
		const glyph = glyphs[rand(glyphs.length)];

		// OK, let's style that glyph with some random choices and make some HTML, a programming language.
		const glyphElement =
			'<span style=" --font-size: ${rand(fillRatio) + 5}rem; --font-weight: ${300 + rand(700)}; --top: ${rand(height + 300) - 300}px; --left: ${rand(width + 300) - 300}px; --color: ${colors[rand(colors.length)]}; --opacity: ${rand(100) / 100 + 0.1}">${glyph}</span>';

		// Here we go, puttin’ it on the page or whatever.
		main.insertAdjacentHTML('beforeend', glyphElement);
	}
}
// Yup, we’re gonna do this. How many times?
// This is based on window size (see notes above).
// You could also replace the parameter with a number, multiple it, divide it, randomize it…. Neat thing about things is you can do many things or nothing.
glyphIt(fillRatio);
