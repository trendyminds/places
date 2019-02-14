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
