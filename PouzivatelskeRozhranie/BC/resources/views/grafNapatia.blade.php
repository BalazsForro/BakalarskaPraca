@extends('navbar')
@section('body')
    <div class="row">
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('grafNapatia') }}" method="get">
                        <b>Filtrovať:</b>
                        <select class="form-select" id="deviceSelect" name="device">
                            </option>
                            @foreach($devices as $device)
                                <option value="{{ $device->id }}"
                                    {{ request()->input('device') == $device->id ? 'selected' : ''}}>
                                    {{ $device->name }}
                                </option>
                            @endforeach
                        </select>
                        <br>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="based" value="last"
                                   id="radioLast100" {{ request()->input('based') != [] ? request()->input('based') == 'last' ? 'checked' : '' : 'checked'}}>
                            <label class="form-check-label" for="radioDatumACas">
                                Posledné 100 údaje
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="based" value="date"
                                   id="radioDatum" {{ request()->input('based') == 'date' ? 'checked' : ''}}>
                            <label class="form-check-label" for="radioDatumACas">
                                Podľa dátumu
                            </label>
                            <div class="input-group date">
                                <input type="text" name="date" class="form-control" autocomplete="off" id="dateInput"
                                       value="{{ request()->input('based') == 'date' ?  request()->get('date') : ''}}">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-primary" type="submit">Filtrovať</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <canvas id="lineChart"></canvas>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        $(document).ready(function () {
            //pri nacitani
            var first_load = true;
            var ctx = document.getElementById('lineChart').getContext('2d');
            var myChart;

            fetchData();

            first_load = false;

            //kazom x intervale
            setInterval(function () {
                fetchData();
            }, 1000);

            var existingData = [];

            function fetchData() {

                var currentUrl = new URL(window.location.href);
                var searchParams = new URLSearchParams(currentUrl.search);
                var data = {};
                for (const [key, value] of searchParams) {
                    data[key] = value;
                }

                //ajax
                $.ajax({
                    type: 'GET',
                    url: '/grafNapatia/ajax',
                    data: data,//{device: $('#deviceSelect').val()},
                    success: function (data) {
                        console.log(data);

                        // Kontrola, či sa prijaté údaje líšia od existujúcich údajov
                        if (JSON.stringify(existingData) !== JSON.stringify(data['voltage'])) {
                            existingData = data['voltage'];
                            if (myChart) {
                                myChart.destroy();
                            }

                            //reformátovanie dátumu kvoli jsonu
                            var dateLabels = first_load ? @json($data['created_at']) : data['created_at'];
                            var formattedDateLabels = dateLabels.map(function (dateString) {
                                var date = new Date(dateString);
                                var options = {
                                    year: 'numeric',
                                    month: 'numeric',
                                    day: 'numeric',
                                    hour: 'numeric',
                                    minute: 'numeric',
                                    timeZone: 'UTC',
                                    hour12: false
                                };
                                return date.toLocaleString('sk-SK', options);
                            });

                            //Vytvoriť Graf
                            myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: formattedDateLabels,
                                    datasets: [{
                                        label: 'Elektrické napätie (V)',
                                        data: existingData,
                                        borderColor: 'rgb(255,0,0)',
                                        borderWidth: 1,
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });

            }

            //datepicker
            $('.input-group.date').datepicker({
                todayHighlight: true,
                clearBtn: true,
            });

            //Sleduje zmenu stavu radiobuttonu, ktorý filtruje dátum.
            $('#radioDatum').change(function () {
                if ($(this).is(':checked')) {
                    $('input[name="date"]').attr('required', true);
                } else {
                    $('input[name="date"]').removeAttr('required');
                }
            });

            //Sleduje zmeny vo vstupnom poli dátumu.
            $('#dateInput').on('change', function () {
                $('#radioDatum').attr('checked', true);
            })
        });
    </script>
@endsection
