/*

Alternative to canvas:

Convert uploaded images to PDF and then use <embed> tag to preview those PDFs as image viewers (zoom/swipe features + responsive)

*/
// If we swipe right, image will be translated to the left
// If we swipe left, image will be translated to the right
// If we swipe up, image will be translated to the bottom
// If we swipe bottom, image will be translated to the top
//
// Make sure user doesn't swipe the image outside of its boundaries
//
// TODO: Add zooming/unzooming feature
// TODO: Algorithm that will calculate image's size relative to the user's device while also respecting image's resolution

import { isNull } from "../utils";

const canvas = document.getElementById('doc-canvas');
const ctx = canvas.getContext('2d');
const docImage = document.getElementById('doc-image');

let screenWidth = window.innerWidth;
let screenHeight = window.innerHeight;

let ongoingTouches = [];
let imageX = 0;
let imageY = 0;
let imageWidth;
let imageHeight;
let swipeSpeed = 15;

calcImageSize();
onWindowResize();
initEvents();

function initEvents() {
  canvas.addEventListener('touchstart', onTouchStart);
  canvas.addEventListener('touchmove', onTouchMove);
  window.addEventListener('resize', onWindowResize);
}

function onTouchStart(event) {
  event.preventDefault();

  saveStartTouches(event);
}

function onTouchMove(event) {
  event.preventDefault();

  const touches = event.changedTouches;

  for (let i = 0; i < touches.length; i++) {
    const touch = touches[i];
    handleSwiping(touch);
  }
}

function saveStartTouches(event) {
  // reset ongoing touches
  ongoingTouches = [];
  const touches = event.changedTouches;

  for (let i = 0; i < touches.length; i++) {
    ongoingTouches.push(touches[i]);
  }
}

function handleSwiping(newTouch) {
  // Check if we have any touches to compare the new touch with
  if (ongoingTouches.length > 0) {
    if (isSwipingLeftWithinBoundaries(newTouch)) {
      translateImage(swipeSpeed);
    }
    else if (isSwipingRightWithinBoundaries(newTouch)) {
      translateImage(-swipeSpeed);
    }
    if (isSwipingBottomWithinBoundaries(newTouch)) {
      translateImage(0, swipeSpeed);
    }
    else if (isSwipingTopWithinBoundaries(newTouch)) {
      translateImage(0, -swipeSpeed);
    }
  }

  // Append the new touch and remove the previous one
  ongoingTouches.push(newTouch);
  ongoingTouches.splice(0, 1);
}

function isSwipingLeftWithinBoundaries(newTouch) {
  return (newTouch.screenX > ongoingTouches[0].screenX) && (imageX + swipeSpeed) < 0;
}

function isSwipingRightWithinBoundaries(newTouch) {
  return (newTouch.screenX < ongoingTouches[0].screenX) && (imageX - screenWidth - swipeSpeed) >= -imageWidth;
}

function isSwipingTopWithinBoundaries(newTouch) {
  return (newTouch.screenY < ongoingTouches[0].screenY) && (imageY - screenHeight - swipeSpeed) >= -imageHeight;
}

function isSwipingBottomWithinBoundaries(newTouch) {
  return (newTouch.screenY > ongoingTouches[0].screenY) && (imageY + swipeSpeed) < 0;
}

function onWindowResize() {
  screenWidth = window.innerWidth;
  screenHeight = window.innerHeight;

  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;

  draw();
}

function calcImageSize() {
  if (docImage.width < 1000 || docImage.height < 1000) {
    imageWidth = docImage.width;
    imageHeight = docImage.height;
  }
  else if (docImage.width > docImage.height) {
    imageWidth = 1200;
    imageHeight = 900;
  }
  else if (docImage.width < docImage.height) {
    imageWidth = 900;
    imageHeight = 1200;
  }
  else if (docImage.width == docImage.height) {
    imageWidth = 1200;
    imageHeight = 1200;
  }
}

function draw() {
  ctx.drawImage(docImage, 0, -10, imageWidth, imageHeight);
}

function translateImage(x, y) {
  if (!isNull(x)) imageX += x;
  if (!isNull(y)) imageY += y;

  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.drawImage(docImage, imageX, imageY, imageWidth, imageHeight);
}
