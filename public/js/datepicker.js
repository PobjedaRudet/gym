/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************!*\
  !*** ./resources/js/datepicker.js ***!
  \************************************/
$(function () {
  $("#datepicker").datepicker({
    autoclose: true,
    todayHighlight: true
  }).datepicker('update', new Date());
  $("#datepicker2").datepicker({
    autoclose: true,
    todayHighlight: true
  }).datepicker('update', new Date());
});
/******/ })()
;