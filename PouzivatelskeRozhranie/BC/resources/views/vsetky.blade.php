@extends('navbar')
@section('body')

    <style>
        .pagination {
            --bs-pagination-color: black;
            --bs-pagination-active-bg: #414141;
            --bs-pagination-active-border-color: #414141;
        }

    </style>

    <div class="row">
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('vsetky') }}" method="get">
                        <b>Filtrovať:</b>
                        <select class="form-select" id="deviceSelect" name="device">
                            <option value="vsetko"> Všetko
                            </option>
                            @foreach($devices as $device)
                                <option value="{{ $device->id }}"
                                    {{ request()->input('device') == $device->id ? 'selected' : ''}}>
                                    {{ $device->name }}
                                </option>
                            @endforeach
                        </select>
                        <br>
                        <div class="input-daterange" id="datepicker">
                            <span class="input-group-addon">od</span>
                            <input type="text" class="input-sm form-control" name="start"
                                   value="{{ request()->get('start') }}"/>
                            <br>
                            <span class="input-group-addon">do</span>
                            <input type="text" class="input-sm form-control" name="end"
                                   value="{{ request()->get('end') }}"/>
                        </div>
                        <br>
                        <b>Zoradiť:</b>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="zoradenie" value="desc" id="radioZost"
                                   checked>
                            <label class="form-check-label" for="radioZost">
                                Zostupne
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="zoradenie" value="asc" id="radioVzost"
                                {{ request()->input('zoradenie') == 'asc' ? 'checked' : ''}}>
                            <label class="form-check-label" for="radioVzost">
                                Vzostupne
                            </label>
                        </div>
                        <b>Podľa:</b>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stlpec" value="created_at" id="radioDatumACas" checked>
                            <label class="form-check-label" for="radioDatumACas">
                                Dátum a čas
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stlpec" value="voltage" id="radioNapatie"
                                {{ request()->input('stlpec') == 'voltage' ? 'checked' : ''}}>
                            <label class="form-check-label" for="radioNapatie">
                                Napätie
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stlpec" value="current" id="radioPrud"
                                {{ request()->input('stlpec') == 'current' ? 'checked' : ''}}>
                            <label class="form-check-label" for="radioPrud">
                                Prúd
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stlpec" value="power" id="radioVykon"
                                {{ request()->input('stlpec') == 'power' ? 'checked' : ''}}>
                            <label class="form-check-label" for="radioVykon">
                                Výkon
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stlpec" value="light"
                                   id="radioSvetelnost"
                                {{ request()->input('stlpec') == 'light' ? 'checked' : ''}}>
                            <label class="form-check-label" for="radioSvetelnost">
                                Svetelnosť
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stlpec" value="effectivity"
                                   id="radioEfektivita"
                                {{ request()->input('stlpec') == 'effectivity' ? 'checked' : ''}}>
                            <label class="form-check-label" for="radioEfektivita">
                                Efektivita
                            </label>
                        </div>
                        <br>

                        <button class="btn btn-primary" type="submit">Filtrovať a zoradiť</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <table class="table table-striped mb-4">
                <thead>
                <tr>
                    <th scope="col">Dátum a čas</th>
                    <th scope="col">Napätie</th>
                    <th scope="col">Prúd</th>
                    <th scope="col">Výkon</th>
                    <th scope="col">Svetelnosť</th>
                    <th scope="col">Efektivita</th>
                    <th scope="col">Zariadenie</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $i => $d)
                    <tr>
                        <th scope="row">{{ $d->created_at }}</th>
                        <td>{{ $d->voltage }}</td>
                        <td>{{ $d->current }}</td>
                        <td>{{ $d->power }}</td>
                        <td>{{ $d->light }}</td>
                        <td>{{ $d->effectivity }}</td>
                        <td>{{ $d->device->name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $('.input-daterange').datepicker({
            todayHighlight: true,
            clearBtn: true,
        });
    </script>

    {{ $data->appends(request()->query())->links('pagination::bootstrap-5') }}
@endsection
