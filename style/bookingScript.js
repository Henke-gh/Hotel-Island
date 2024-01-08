document.addEventListener('DOMContentLoaded', function () {
  // Function to update the cost summary
  function updateCostSummary() {
    // Get the selected room cost
    var selectedRoomID = getSelectedRoomID();
    var roomCost = parseInt(getRoomCost(selectedRoomID));

    // Get the selected extras cost
    var extrasCost = getExtrasCost();

    // Calculate total cost
    var totalCost = roomCost + extrasCost;

    // Update the cost summary values
    document.getElementById('roomCost').textContent = roomCost + '$';
    document.getElementById('extrasCost').textContent = extrasCost + '$';
    document.getElementById('totalCostValue').textContent = totalCost + '$';
  }

  // Attach change event listeners to radio buttons and checkboxes
  var roomRadios = document.getElementsByName('selectedRoomID');
  var extrasCheckboxes = document.getElementsByName('extrasOption[]');

  for (var i = 0; i < roomRadios.length; i++) {
    roomRadios[i].addEventListener('change', updateCostSummary);
  }

  for (var i = 0; i < extrasCheckboxes.length; i++) {
    extrasCheckboxes[i].addEventListener('change', updateCostSummary);
  }

  // Function to get the selected room ID
  function getSelectedRoomID() {
    var selectedRoomID;

    for (var i = 0; i < roomRadios.length; i++) {
      if (roomRadios[i].checked) {
        selectedRoomID = roomRadios[i].value;
        break;
      }
    }

    return selectedRoomID;
  }

  // Function to get the room cost based on room ID
  function getRoomCost(roomID) {
    var roomCostInput = document.querySelector(
      ".roomCost[data-room-id='" + roomID + "']"
    );

    if (roomCostInput) {
      return roomCostInput.value;
    } else {
      return '0';
    }
  }

  // Function to get the selected extras cost
  function getExtrasCost() {
    var extrasCost = 0;

    for (var i = 0; i < extrasCheckboxes.length; i++) {
      if (extrasCheckboxes[i].checked) {
        // Get the cost from the hidden input using the data-extra-id attribute
        var extraID = extrasCheckboxes[i].value;
        var extraCostInput = document.querySelector(
          ".extraCost[data-extra-id='" + extraID + "']"
        );

        if (extraCostInput) {
          extrasCost += parseInt(extraCostInput.value);
        }
      }
    }

    return extrasCost;
  }
});
