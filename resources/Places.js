import "./Places.css";

export default class Places {
  constructor($el) {
    this.$el = document.querySelector($el);

    this.$place = this.$el.querySelector(".js-Places__field--place");
    this.$street = this.$el.querySelector(".js-Places__field--street");
    this.$city = this.$el.querySelector(".js-Places__field--city");
    this.$state = this.$el.querySelector(".js-Places__field--state");
    this.$zip = this.$el.querySelector(".js-Places__field--zip");
    this.$country = this.$el.querySelector(".js-Places__field--country");
    this.$lat = this.$el.querySelector(".js-Places__field--lat");
    this.$lng = this.$el.querySelector(".js-Places__field--lng");

    this.autocomplete = {};

    this.fillAddress = this.fillAddress.bind(this);

    this.init();
    this.events();
  }

  init() {
    this.autocomplete = new google.maps.places.Autocomplete(this.$place, {
      types: ["geocode", "establishment"]
    });

    this.autocomplete.setFields([
      "address_components",
      "geometry.location",
      "icon",
      "name"
    ]);
  }

  events() {
    this.autocomplete.addListener("place_changed", this.fillAddress);

    // Prevent the entry from saving when a user selects an option using the enter key
    this.$place.addEventListener("keydown", ev => {
      if (ev.key === "Enter") {
        ev.preventDefault();
      }
    });
  }

  getComponent(address, item, format = "long_name") {
    let result = "";

    const component = address.filter(el => el.types.includes(item));

    if (component.length) {
      result = component[0][format];
    }

    return result;
  }

  getAddress({ address_components, geometry }) {
    return {
      street: `${this.getComponent(
        address_components,
        "street_number"
      )} ${this.getComponent(address_components, "route", "short_name")}`,
      city: this.getComponent(address_components, "locality"),
      state: this.getComponent(
        address_components,
        "administrative_area_level_1",
        "short_name"
      ),
      zip: this.getComponent(address_components, "postal_code"),
      country: this.getComponent(address_components, "country"),
      lat: geometry.location.lat(),
      lng: geometry.location.lng()
    };
  }

  fillAddress() {
    const address = this.getAddress(this.autocomplete.getPlace());

    this.$street.value = address.street;
    this.$city.value = address.city;
    this.$state.value = address.state;
    this.$zip.value = address.zip;
    this.$country.value = address.country;
    this.$lat.value = address.lat;
    this.$lng.value = address.lng;
  }
}

window.PlacesField = Places;

// // This sample uses the Autocomplete widget to help the user select a
// // place, then it retrieves the address components associated with that
// // place, and then it populates the form fields with those details.
// // This sample requires the Places library. Include the libraries=places
// // parameter when you first load the API. For example:
// // <script
// // src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

// var placeSearch, autocomplete;

// var componentForm = {
//   street_number: 'short_name',
//   route: 'long_name',
//   locality: 'long_name',
//   administrative_area_level_1: 'short_name',
//   country: 'long_name',
//   postal_code: 'short_name'
// };

// function initAutocomplete() {
//   // Create the autocomplete object, restricting the search predictions to
//   // geographical location types.
//   autocomplete = new google.maps.places.Autocomplete(
//       document.getElementById('autocomplete'), {types: ['geocode']});

//   // Avoid paying for data that you don't need by restricting the set of
//   // place fields that are returned to just the address components.
//   autocomplete.setFields('address_components');

//   // When the user selects an address from the drop-down, populate the
//   // address fields in the form.
//   autocomplete.addListener('place_changed', fillInAddress);
// }

// function fillInAddress() {
//   // Get the place details from the autocomplete object.
//   var place = autocomplete.getPlace();

//   for (var component in componentForm) {
//     document.getElementById(component).value = '';
//     document.getElementById(component).disabled = false;
//   }

//   // Get each component of the address from the place details,
//   // and then fill-in the corresponding field on the form.
//   for (var i = 0; i < place.address_components.length; i++) {
//     var addressType = place.address_components[i].types[0];
//     if (componentForm[addressType]) {
//       var val = place.address_components[i][componentForm[addressType]];
//       document.getElementById(addressType).value = val;
//     }
//   }
// }

// // Bias the autocomplete object to the user's geographical location,
// // as supplied by the browser's 'navigator.geolocation' object.
// function geolocate() {
//   if (navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(function(position) {
//       var geolocation = {
//         lat: position.coords.latitude,
//         lng: position.coords.longitude
//       };
//       var circle = new google.maps.Circle(
//           {center: geolocation, radius: position.coords.accuracy});
//       autocomplete.setBounds(circle.getBounds());
//     });
//   }
// }
