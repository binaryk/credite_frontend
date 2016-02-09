"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/*
 export function summ(x, ...y){
 var sum = parseFloat(x);

 y.map(el => {
 sum += el;
 console.log(sum);
 console.log(sum);

 });

 return sum;
 }*/

var Mat = exports.Mat = function () {
  function Mat(a, b) {
    _classCallCheck(this, Mat);

    this.a = a;
    this.b = b;
  }

  _createClass(Mat, [{
    key: "summ",
    value: function summ(a, b) {
      return a + b;
    }
  }, {
    key: "diff",
    value: function diff(a, b) {
      return a - b;
    }
  }, {
    key: "prod",
    value: function prod() {
      return this.a * this.b;
    }
  }]);

  return Mat;
}();