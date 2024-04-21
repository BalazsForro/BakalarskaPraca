@extends('navbar')
@section('body')

    <div>
        <div class="row">
            <div class="col-md-3 mt-4">
                <div class="card text-center" style="height: 70px;">
                    <div class="card-body">
                        <h5 style="font-size: 1.5rem;">Zariadenie:</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-9 mt-4">
                <div class="card text-center" style="height: 70px;">
                    <select class="form-select form-control-lg border-0" id="deviceSelect"
                            style="font-size: 1.5rem; height: 100px;">
                        @foreach($devices as $device)
                            <option value="{{ $device->id }}"> {{ $device->name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card text-center mt-4">
            <div class="card-body" id="created_at">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mt-4">
                <div class="card text-center">
                    <div class="card-header">
                        <h4>Elektrické napätie</h4>
                    </div>
                    <div class="card-body" id="voltage">
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-4">
                <div class="card text-center">
                    <div class="card-header">
                        <h4>Elektrický prúd</h4>
                    </div>
                    <div class="card-body" id="current">
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-4">
                <div class="card text-center">
                    <div class="card-header">
                        <h4>Elektrický výkon</h4>
                    </div>
                    <div class="card-body" id="power">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-4">
                <div class="card text-center">
                    <div class="card-header">
                        <h4>Svetelnosť</h4>
                    </div>
                    <div class="card-body" id="light">
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-4">
                <div class="card text-center">
                    <div class="card-header">
                        <h4>Efektivita</h4>
                    </div>
                    <div class="card-body" id="effectivity">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>

        $(document).ready(function () {
            fetchData();

            $('#deviceSelect').change(function () {
                fetchData();
            });

            setInterval(function () {
                fetchData();
            }, 1000);

            function formatDateTime(dateTimeString) {
                var date = new Date(dateTimeString);
                var options = {
                    year: 'numeric',
                    month: 'numeric',
                    day: 'numeric',
                    hour: 'numeric',
                    minute: 'numeric',
                    second: 'numeric',
                    timeZone: 'UTC',
                    hour12: false
                };
                return date.toLocaleString('sk-SK', options);
            }

            function fetchData() {
                var devices = {!! json_encode($devices->toArray()) !!};
                var deviceId = $('#deviceSelect').val();

                $.ajax({
                    type: 'GET',
                    url: '/get-data/' + deviceId,
                    success: function (data) {
                        var formattedDateTime = formatDateTime(data.created_at);
                        console.log(data);
                        $('#created_at').html(`<h1> ${formattedDateTime} </h1>`);
                        $('#voltage').html(`<h1> ${parseFloat(data.voltage).toFixed(2)} V</h1>`);
                        $('#current').html(`<h1> ${parseFloat(data.current).toFixed(2)} A</h1>`);
                        $('#power').html(`<h1> ${data.power} W</h1>`);
                        $('#light').html(`<h1> ${data.light} lux</h1>`);
                        $('#effectivity').html(`<h1> ${data.effectivity} %</h1>`);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        });
    </script>
@endsection
