//Adds selected class to selected dates in calendar, changes bg-color
document.addEventListener('DOMContentLoaded', function () {
  var calendarDays = document.querySelectorAll('.calendar-day');

  calendarDays.forEach(function (day) {
    day.addEventListener('click', function () {
      day.classList.toggle('selected');
    });
  });
});
