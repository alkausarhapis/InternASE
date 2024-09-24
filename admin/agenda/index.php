<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Event Calendar</title>

    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="../assets/css/styles.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="../assets/js/scripts.js"></script>
</head>

<body>
    <div id="nav-container">
        <?php include '../view/navbar.php';?>
    </div>


    <!-- Calendar -->
    <div id="calendar-container">
        <h1 class="text-center p-2">Agenda</h1>
        <div id='calendar'></div>
    </div>

    <!-- Modal new event -->
    <div class="modal fade modal-lg" id="eventModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header custom-bg">
                    <h4 id="event-modal-header-title" class="modal-title text-white">New Event</h4>
                </div>
                <div class="modal-body">
                    <form id="eventForm" class="d-flex flex-column gap-3">
                        <input type="hidden" id="event_id_agenda" name="id_agenda">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="w-25" for="event_agenda_name">Event Name</label>
                            <input type="text" class="form-control w-75" id="event_agenda_name" name="agenda_name"
                                required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="w-25" for="event_date">Date</label>
                            <input type="datetime-local" class="form-control w-75" id="event_date" name="date" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="w-25" for="event_type">Type</label>
                            <input type="text" class="form-control w-75" id="event_type" name="type">
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="w-25" for="event_desc">Description</label>
                            <textarea class="form-control w-75" id="event_desc" name="desc"></textarea>
                        </div>
                        <div class="modal-footer mt-4 pb-0">
                            <button type="button" class="btn btn-secondary rounded-5 px-4"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-custom rounded-5 px-4" id="saveEvent">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal preview -->
    <div class="modal fade modal-lg" id="previewModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header custom-bg">
                    <h4 id="preview-modal-header-title" class="modal-title text-white">Event Details</h4>
                </div>
                <div class="modal-body">
                    <form id="previewForm" class="d-flex flex-column gap-3">
                        <input type="hidden" id="preview_id_agenda" name="id_agenda">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="w-25" for="preview_agenda_name">Event Name</label>
                            <input type="text" class="form-control w-75" id="preview_agenda_name" name="agenda_name"
                                required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="w-25" for="preview_date">Date</label>
                            <input type="datetime-local" class="form-control w-75" id="preview_date" name="date"
                                required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="w-25" for="preview_type">Type</label>
                            <input type="text" class="form-control w-75" id="preview_type" name="type">
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="w-25" for="preview_desc">Description</label>
                            <textarea class="form-control w-75" id="preview_desc" name="desc"></textarea>
                        </div>
                        <div class="modal-footer mt-4 pb-0">
                            <button type="button" class="btn btn-secondary rounded-5 px-4"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-danger rounded-5 px-4" id="deleteEvent">Hapus</button>
                            <button type="submit" class="btn btn-custom rounded-5 px-4" id="saveEvent">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FullCalendarJS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            displayEventTime: false,
            height: '100%',
            firstDay: 1,
            events: 'fetch_events.php',
            editable: false,
            selectable: true,
            customButtons: {
                // Custom button add event
                addEvent: {
                    text: 'New event',
                    click: function() {
                        document.getElementById('eventForm').reset();
                        eventModal.show();
                    }
                }
            },
            headerToolbar: {
                left: 'title',
                right: 'addEvent,today,prev,next'
            },
            select: function(info) {
                document.getElementById('eventForm').reset();

                // Autofill input date, by the selected date
                const date = new Date(info.start);
                date.setHours(15, 0, 0, 0);
                const dateString = date.toISOString().slice(0, 16);
                document.getElementById('event_date').value = dateString;

                eventModal.show();
            },
            eventClick: function(info) {
                document.getElementById('preview-modal-header-title').textContent = info.event
                    .title;
                document.getElementById('preview_id_agenda').value = info.event.id;
                document.getElementById('preview_agenda_name').value = info.event.title;

                // Fill input date
                const date = new Date(info.event.start);
                const cleanedDate = date.getFullYear() + '-' +
                    ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                    ('0' + date.getDate()).slice(-2) + 'T' +
                    ('0' + date.getHours()).slice(-2) + ':' +
                    ('0' + date.getMinutes()).slice(-2);
                document.getElementById('preview_date').value = cleanedDate;

                document.getElementById('preview_type').value = info.event.extendedProps.type || '';
                document.getElementById('preview_desc').value = info.event.extendedProps.desc || '';
                previewModal.show();
            }
        });
        calendar.render();

        // Flasher
        function showFlasher(type, message) {
            const flasher = document.createElement('div');
            flasher.className = `alert alert-${type} alert-dismissible text-start fade show align-items-center`;
            flasher.role = 'alert';
            flasher.innerHTML = `
            <i class="fa fa-circle-check fa-xl me-2"></i> ${message}
            <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        `;
            const calendarContainer = document.getElementById('calendar-container');
            // Render flasher before fullCalendar
            calendarContainer.insertBefore(flasher, calendarContainer.querySelector('#calendar'));
            setTimeout(() => flasher.remove(), 3000);
        }

        // Submit data using fetch
        document.getElementById('eventForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            fetch('add_event.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    eventModal.hide();
                    calendar.refetchEvents();
                    showFlasher('success', 'Berhasil menambahkan event');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showFlasher('danger', 'Terjadi kesalahan. Silakan coba lagi.');
                });
        });

        // Update event using fetch
        document.getElementById('previewForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            fetch('update_event.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    previewModal.hide();
                    calendar.refetchEvents();
                    showFlasher('primary', 'Event berhasil diperbarui');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showFlasher('danger', 'Terjadi kesalahan. Silakan coba lagi.');
                });
        });

        // Delete event using fetch
        document.getElementById('deleteEvent').addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this event?')) {
                const formData = new FormData();
                formData.append('id_agenda', document.getElementById('preview_id_agenda').value);

                fetch('delete_event.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        previewModal.hide();
                        calendar.refetchEvents();
                        showFlasher('warning', 'Berhasil menghapus event');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showFlasher('danger', 'Terjadi kesalahan. Silakan coba lagi.');
                    });
            }
        });
    });
    </script>



</body>

</html>