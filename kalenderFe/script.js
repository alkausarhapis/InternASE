// Select all calendar elements
const currentMonths = document.querySelectorAll(".current-month");
const calendarDaysContainers = document.querySelectorAll(".calendar-days");
const startTimeInput = document.getElementById("startTime");
const endTimeInput = document.getElementById("endTime");

// Get the current date
const today = new Date();
today.setHours(0, 0, 0, 0); // Reset time to ensure accurate comparison

let globalDate = new Date(); // Keep a global reference of the date
let selectedStartDate = null; // Track the selected start date
let selectedEndDate = null; // Track the selected end date

// Set the initial text for each current month
currentMonths.forEach((currentMonth) => {
  currentMonth.textContent = globalDate.toLocaleDateString("en-US", {
    month: "long",
    year: "numeric",
  });
});

// Function to render the calendar for a specific element
function renderCalendar(containerIndex) {
  const calendarDays = calendarDaysContainers[containerIndex];
  const currentMonth = currentMonths[containerIndex];

  const currentCalendarDate = new Date(globalDate); // Clone the global date for local use

  const prevLastDay = new Date(
    currentCalendarDate.getFullYear(),
    currentCalendarDate.getMonth(),
    0
  ).getDate();
  const totalMonthDay = new Date(
    currentCalendarDate.getFullYear(),
    currentCalendarDate.getMonth() + 1,
    0
  ).getDate();
  const startWeekDay = new Date(
    currentCalendarDate.getFullYear(),
    currentCalendarDate.getMonth(),
    1
  ).getDay();

  calendarDays.innerHTML = "";

  // Display the previous month's days
  for (let i = 0; i < startWeekDay; i++) {
    calendarDays.innerHTML += `<div class="padding-day">${
      prevLastDay - startWeekDay + 1 + i
    }</div>`;
  }

  // Display the current month's days
  for (let i = 1; i <= totalMonthDay; i++) {
    const loopDate = new Date(
      currentCalendarDate.getFullYear(),
      currentCalendarDate.getMonth(),
      i
    );
    let dayClass = "month-day";
    if (loopDate.getTime() === today.getTime()) {
      dayClass = "current-day"; // Highlight today's date
    } else if (
      selectedStartDate &&
      selectedEndDate &&
      loopDate >= selectedStartDate &&
      loopDate <= selectedEndDate
    ) {
      dayClass = "selected-date"; // Highlight the selected date range
    }
    calendarDays.innerHTML += `<div class="${dayClass}">${i}</div>`;
  }

  // Fill in the next month's days to complete the grid
  const remainingDays = 42 - calendarDays.children.length; // 6 weeks x 7 days
  for (let i = 1; i <= remainingDays; i++) {
    calendarDays.innerHTML += `<div class="padding-day">${i}</div>`;
  }
}

// Render all calendars initially
calendarDaysContainers.forEach((_, index) => renderCalendar(index));

// Add event listeners for month navigation buttons
document.querySelectorAll(".month-btn").forEach((element) => {
  element.addEventListener("click", function () {
    const isPrev = element.classList.contains("prev");
    globalDate.setMonth(globalDate.getMonth() + (isPrev ? -1 : 1));

    // Update all calendar headers
    currentMonths.forEach((currentMonth) => {
      currentMonth.textContent = globalDate.toLocaleDateString("en-US", {
        month: "long",
        year: "numeric",
      });
    });

    // Render all calendars
    calendarDaysContainers.forEach((_, index) => renderCalendar(index));
  });
});

// Add event listeners for "Today" buttons
document.querySelectorAll(".btn").forEach(function (element) {
  element.addEventListener("click", function () {
    let btnClass = element.classList;
    if (btnClass.contains("today")) globalDate = new Date();

    // Update all calendar headers
    currentMonths.forEach((currentMonth) => {
      currentMonth.textContent = globalDate.toLocaleDateString("en-US", {
        month: "long",
        year: "numeric",
      });
    });

    // Render all calendars
    calendarDaysContainers.forEach((_, index) => renderCalendar(index));
  });
});

// Add event listeners to the start and end date inputs
[startTimeInput, endTimeInput].forEach((input) => {
  input.addEventListener("change", function () {
    const startDate = new Date(startTimeInput.value);
    const endDate = new Date(endTimeInput.value);

    // Check if both dates are selected and valid
    if (startDate && endDate && startDate <= endDate) {
      selectedStartDate = new Date(startDate.setHours(0, 0, 0, 0));
      selectedEndDate = new Date(endDate.setHours(0, 0, 0, 0));
    } else {
      selectedStartDate = null;
      selectedEndDate = null;
    }

    // Re-render all calendars to highlight the selected range
    calendarDaysContainers.forEach((_, index) => renderCalendar(index));
  });
});
