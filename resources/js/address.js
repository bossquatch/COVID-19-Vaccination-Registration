let placeSearch;
let autocomplete;

const componentForm = {
  street_number: "short_name",
  route: "short_name",
  locality: "long_name",
  administrative_area_level_2: "short_name",
  administrative_area_level_1: "short_name",
  postal_code: "short_name"
};

function initAutocomplete() {
  autocomplete = new google.maps.places.Autocomplete(
    document.getElementById("autocomplete"),
    { types: ["geocode"] }
  );

  autocomplete.setFields(["address_component", "geometry"]);

  autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
  const place = autocomplete.getPlace();

  const lat = place.geometry.location.lat(),
    lng = place.geometry.location.lng();

  document.getElementById("lat").value = lat;
  document.getElementById("lng").value = lng;

  for (const component in componentForm) {
    document.getElementById(component).value = "";
    document.getElementById(component).disabled = true;
  }

  for (const component of place.address_components) {
    const addressType = component.types[0];

    if (componentForm[addressType]) {
      const val = component[componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}

function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition((position) => {
      const geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      const circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });

      autocomplete.setBounds(circle.getBounds());
    });
  }
}

document.getElementById("btnCollapsedAddress").addEventListener("click", function () {
    if (this.getAttribute("aria-expanded") === "false") {
      for (const component in componentForm) {
        document.getElementById(component).disabled = false;
      }
    }
});

document.getElementById("autocomplete").addEventListener("input", function () {
  document.getElementById("addressMoreOptions").classList.add("animate-fade-in");
});
