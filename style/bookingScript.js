document.addEventListener('DOMContentLoaded', function () {
  // PHP variable containing extras cost
  var extrasCost = 0;

  // Function to calculate total cost
  function calculateTotalCost() {
    var numberOfDays = 0;
    var roomCost = 0;
    var totalCost = numberOfDays * roomCost;

    // Add extra costs based on selected extras
    var selectedExtras = document.querySelectorAll(
      'input[name="extrasOption[]"]:checked'
    );
    selectedExtras.forEach(function (extra) {
      totalCost += parseFloat(extra.dataset.cost);
    });

    // Update the total cost display
    document.getElementById('totalCost').textContent =
      'Total Cost: $' + totalCost.toFixed(2);
  }

  // Attach event listeners to room selection and extras checkboxes
  var roomRadios = document.querySelectorAll('input[name="selectedRoomID"]');
  roomRadios.forEach(function (radio) {
    radio.addEventListener('change', calculateTotalCost);
  });

  var extraCheckboxes = document.querySelectorAll(
    'input[name="extrasOption[]"]'
  );
  extraCheckboxes.forEach(function (checkbox) {
    // Set the data-cost attribute using PHP variable
    checkbox.dataset.cost = extrasCost;
    checkbox.addEventListener('change', calculateTotalCost);
  });
});
