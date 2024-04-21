<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Device;
use DateTime;
use Illuminate\Http\Request;

class DataController extends Controller
{
// --- Aktuálne údaje -------------------------------------------------------------------------------------------------
    public function aktualny()
    {
        $devices = Device::all();

        $aktualData = Data::all()
            ->where('device_id', 1)
            ->last();

        return view('aktualny',
            compact('devices', 'aktualData')
        );
    }
    public function getData($deviceId)
    {
        $aktualData = Data::where('device_id', $deviceId)
            ->latest()
            ->first();

        return response()->json($aktualData);
    }

// --- Graf napätia -------------------------------------------------------------------------------------------------
    private function getDataBasedVoltage(Request $request)
    {
        $data = [
            'created_at' => [],
            'voltage' => [],
        ];

        if ($request->all() == []) {
            $dataQuery = Data::select('created_at', 'voltage')
                ->where('device_id', 1)
                ->take(100)
                ->orderBy('created_at', 'desc')
                ->get();

            $index = 0;
            foreach ($dataQuery->reverse() as $d) {
                $data['created_at'][$index] = $d->created_at;
                $data['voltage'][$index] = $d->voltage;
                $index++;
            }

            return $data;
        }

        $dataQuery = Data::select('created_at', 'voltage')
            ->where('device_id', $request->get('device'));


        if ($request->input('based') == 'last') {
            $dataQuery->take(100);
        } else if ($request->input('based') == 'date') {
            $startDate = DateTime::createFromFormat('Y-m-d', $request->get('date'));
            $startDate->setTime(0, 0);

            $endDate = DateTime::createFromFormat('Y-m-d', $request->get('date'));
            $endDate->setTime(23, 59);

            $dataQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        $dataQuery->orderBy('created_at', 'desc');

        $dataQuery = $dataQuery->get();

        $index = 0;
        foreach ($dataQuery->reverse() as $d) {
            $data['created_at'][$index] = $d->created_at;
            $data['voltage'][$index] = $d->voltage;
            $index++;
        }

        return $data;
    }

    public function grafNapatia(Request $request)
    {
        $data = $this->getDataBasedVoltage($request);
        $devices = Device::all();

        return view('grafNapatia',
            compact('data', 'devices')
        );
    }

    public function grafNapatiaAjax(Request $request)
    {
        $data = $this->getDataBasedVoltage($request);

        return response()->json($data);
    }

// --- Graf prúdu -------------------------------------------------------------------------------------------------
    private function getDataBasedCurrent(Request $request)
    {
        $data = [
            'created_at' => [],
            'current' => [],
        ];

        if ($request->all() == []) {
            $dataQuery = Data::select('created_at', 'current')
                ->where('device_id', 1)
                ->take(100)
                ->orderBy('created_at', 'desc')
                ->get();

            $index = 0;
            foreach ($dataQuery->reverse() as $d) {
                $data['created_at'][$index] = $d->created_at;
                $data['current'][$index] = $d->current;
                $index++;
            }

            return $data;
        }

        $dataQuery = Data::select('created_at', 'current')
            ->where('device_id', $request->get('device'));


        if ($request->input('based') == 'last') {
            $dataQuery->take(100);
        } else if ($request->input('based') == 'date') {
            $startDate = DateTime::createFromFormat('Y-m-d', $request->get('date'));
            $startDate->setTime(0, 0);

            $endDate = DateTime::createFromFormat('Y-m-d', $request->get('date'));
            $endDate->setTime(23, 59);

            $dataQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        $dataQuery->orderBy('created_at', 'desc');

        $dataQuery = $dataQuery->get();

        $index = 0;
        foreach ($dataQuery->reverse() as $d) {
            $data['created_at'][$index] = $d->created_at;
            $data['current'][$index] = $d->current;
            $index++;
        }

        return $data;
    }

    public function grafPrudu(Request $request)
    {
        $data = $this->getDataBasedCurrent($request);
        $devices = Device::all();

        return view('grafPrudu',
            compact('data', 'devices')
        );
    }

    public function grafPruduAjax(Request $request)
    {
        $data = $this->getDataBasedCurrent($request);

        return response()->json($data);
    }

    // --- Graf výkonu -------------------------------------------------------------------------------------------------
    private function getDataBasedPower(Request $request)
    {
        $data = [
            'created_at' => [],
            'power' => [],
        ];

        if ($request->all() == []) {
            $dataQuery = Data::select('created_at', 'power')
                ->where('device_id', 1)
                ->take(100)
                ->orderBy('created_at', 'desc')
                ->get();

            $index = 0;
            foreach ($dataQuery->reverse() as $d) {
                $data['created_at'][$index] = $d->created_at;
                $data['power'][$index] = $d->power;
                $index++;
            }

            return $data;
        }

        $dataQuery = Data::select('created_at', 'power')
            ->where('device_id', $request->get('device'));


        if ($request->input('based') == 'last') {
            $dataQuery->take(100);
        } else if ($request->input('based') == 'date') {
            $startDate = DateTime::createFromFormat('Y-m-d', $request->get('date'));
            $startDate->setTime(0, 0);

            $endDate = DateTime::createFromFormat('Y-m-d', $request->get('date'));
            $endDate->setTime(23, 59);

            $dataQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        $dataQuery->orderBy('created_at', 'desc');

        $dataQuery = $dataQuery->get();

        $index = 0;
        foreach ($dataQuery->reverse() as $d) {
            $data['created_at'][$index] = $d->created_at;
            $data['power'][$index] = $d->power;
            $index++;
        }

        return $data;
    }

    public function grafVykonu(Request $request)
    {
        $data = $this->getDataBasedPower($request);
        $devices = Device::all();

        return view('grafVykonu',
            compact('data', 'devices')
        );
    }

    public function grafVykonuAjax(Request $request)
    {
        $data = $this->getDataBasedPower($request);

        return response()->json($data);
    }

// --- Graf svetelnosti -------------------------------------------------------------------------------------------------
    private function getDataBasedLight(Request $request)
    {
        $data = [
            'created_at' => [],
            'light' => [],
        ];

        if ($request->all() == []) {
            $dataQuery = Data::select('created_at', 'light')
                ->where('device_id', 1)
                ->take(100)
                ->orderBy('created_at', 'desc')
                ->get();

            $index = 0;
            foreach ($dataQuery->reverse() as $d) {
                $data['created_at'][$index] = $d->created_at;
                $data['light'][$index] = $d->light;
                $index++;
            }

            return $data;
        }

        $dataQuery = Data::select('created_at', 'light')
            ->where('device_id', $request->get('device'));


        if ($request->input('based') == 'last') {
            $dataQuery->take(100);
        } else if ($request->input('based') == 'date') {
            $startDate = DateTime::createFromFormat('Y-m-d', $request->get('date'));
            $startDate->setTime(0, 0);

            $endDate = DateTime::createFromFormat('Y-m-d', $request->get('date'));
            $endDate->setTime(23, 59);

            $dataQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        $dataQuery->orderBy('created_at', 'desc');

        $dataQuery = $dataQuery->get();

        $index = 0;
        foreach ($dataQuery->reverse() as $d) {
            $data['created_at'][$index] = $d->created_at;
            $data['light'][$index] = $d->light;
            $index++;
        }

        return $data;
    }

    public function grafSvetelnosti(Request $request)
    {
        $data = $this->getDataBasedLight($request);
        $devices = Device::all();

        return view('grafSvetelnosti',
            compact('data', 'devices')
        );
    }

    public function grafSvetelnostiAjax(Request $request)
    {
        $data = $this->getDataBasedLight($request);
        return response()->json($data);
    }

// --- Všetky údaje -------------------------------------------------------------------------------------------------
    public function vsetky(Request $request)
    {
        $query = Data::select('*');

        if ($request->get('device') && $request->get('device') != 'vsetko') {
            $query->where('device_id', $request->get('device'));
        }

        if ($request->get('start') && $request->get('end')) {
            $startDate = DateTime::createFromFormat('Y-m-d', $request->get('start'));
            $startDate->setTime(0, 0);

            $endDate = DateTime::createFromFormat('Y-m-d', $request->get('end'));
            $endDate->setTime(23, 59);

            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($request->get('stlpec')) {
            $query->orderBy(
                $request->get('stlpec'),
                $request->get('zoradenie')
            );
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $devices = Device::all();
        $data = $query->paginate(50);

        return view('vsetky',
            compact('data', 'devices')
        );
    }
}
