var addyKey = '51ebb0e0c87640acb03d7663e17307a1';
function initAddy() {
  var addyComplete = new AddyComplete(document.getElementById('address1'));
  addyComplete.options.excludePostBox = false;
  addyComplete.fields = {
    address1: document.getElementById('address1'),
    address2: document.getElementById('address2'),
    suburb: document.getElementById('suburb'),
    city: document.getElementById('city'),
    postcode: document.getElementById('postcode'),
  }
  // Register a function to receive the selected address object
  addyComplete.addressSelected = function(type) {
    console.log("Selected address object: ", type);
  } 
}

(function (d, w) {
  // Add the address autocomplete JavaScript
  var s = d.createElement('script');
  var addyUrl = 'https://cdn.addy.co.nz/neatcomplete/2.1.0/addycomplete.min.js';
  s.src = addyUrl + '?loadcss=true&enableLocation=true&key=' + addyKey;
  s.type = 'text/javascript';
  s.async = 1;
  s.onload=initAddy;
  d.body.appendChild(s);
})(document, window);