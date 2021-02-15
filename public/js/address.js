/******/ (function() { // webpackBootstrap
/*!*********************************!*\
  !*** ./resources/js/address.js ***!
  \*********************************/
function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

var placeSearch;
var autocomplete;
var componentForm = {
  street_number: "short_name",
  route: "short_name",
  locality: "long_name",
  administrative_area_level_2: "short_name",
  administrative_area_level_1: "short_name",
  postal_code: "short_name"
};

function initAutocomplete() {
  autocomplete = new google.maps.places.Autocomplete(document.getElementById("autocomplete"), {
    types: ["geocode"]
  });
  autocomplete.setFields(["address_component", "geometry"]);
  autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
  var place = autocomplete.getPlace();
  var lat = place.geometry.location.lat(),
      lng = place.geometry.location.lng();
  document.getElementById("lat").value = lat;
  document.getElementById("lng").value = lng;

  for (var component in componentForm) {
    document.getElementById(component).value = "";
    document.getElementById(component).disabled = true;
  }

  var _iterator = _createForOfIteratorHelper(place.address_components),
      _step;

  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var _component = _step.value;
      var addressType = _component.types[0];

      if (componentForm[addressType]) {
        var val = _component[componentForm[addressType]];
        document.getElementById(addressType).value = val;
      }
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }
}

function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
    });
  }
}

document.getElementById("btnCollapsedAddress").addEventListener("click", function () {
  if (this.getAttribute("aria-expanded") === "false") {
    for (var component in componentForm) {
      document.getElementById(component).disabled = false;
    }
  }
});
document.getElementById("autocomplete").addEventListener("input", function () {
  document.getElementById("addressMoreOptions").classList.add("animate-fade-in");
});
/******/ })()
;