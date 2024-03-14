@extends('layouts.mainlayout-ka')

@section('title', 'Detail Surat')

@section('content')
    <div class="w-[90%] h-full mx-auto py-3 px-4 my-10 font-poppins">
        <div id='calendar' class=""></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Tampilan awal kalendar
                events: {!! json_encode($events) !!}, // Data acara dari database
                headerToolbar: {
                    start: 'title',
                    center: 'prevYear,prev,today,next,nextYear', // Tombol navigasi bulan
                    end: 'dayGridMonth,timeGridWeek,timeGridDay' // Tampilan alternatif (opsional)

                },
                locale: 'id'
            });
            calendar.render();
        });
    </script>
@endsection
