/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
var indicator = document.querySelector(".nav-indicator");
var items = document.querySelectorAll(".nav-item");

function handleIndicator(el) {
  items.forEach(function (item) {
    item.classList.remove("is-active");
    item.removeAttribute("style");
  });
  indicator.style.width = "".concat(el.offsetWidth, "px");
  indicator.style.left = "".concat(el.offsetLeft, "px");
  el.classList.add("is-active");
  el.style.color = el.getAttribute("active-color");
}

items.forEach(function (item, index) {
  item.addEventListener("mouseenter", function (e) {
    handleIndicator(e.target);
  });
  item.classList.contains("is-active") && handleIndicator(item);
}); // слайдеры  главная

document.addEventListener("DOMContentLoaded", function (event) {
  window.onload = function () {
    resize_info();
  };

  window.onresize = function () {
    resize_info();
  };
});

function resize_info() {
  // элементы для главной страницы
  var line = $('.main-screen').find('.line'),
      button = $('.main-screen').find('.button'),
      slider = $('.main-screen').find('.main-screen__slider'),
      // элементы для каталога объектов
  sorting_objects = $('.objects-content').find('.sorting__select'),
      button_filters = $('.objects-content').find('.filter-button');

  if (document.documentElement.clientWidth <= 1200) {
    line.before(slider);
    button.after(line);
  }

  if (document.documentElement.clientWidth <= 1024) {
    $('.filters').find('.filter-button').find('input').attr('checked', false);
    $('.filters').find('.filters-block').removeClass('show');
  }

  if (document.documentElement.clientWidth <= 768) {
    button_filters.after(sorting_objects);
  }
}
/******/ })()
;
//# sourceMappingURL=main.js.map