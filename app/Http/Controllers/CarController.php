<?php

namespace App\Http\Controllers;

use App\Exports\CarsExport;
use App\Jobs\UpdateExportStatusToCompleted;
use App\Models\Car;
use App\Models\Export;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class CarController extends Controller
{
    function indexView(Request $request)
    {
        if ($request->ajax()) {
            $data = Car::query();
            return DataTables::of($data)->addColumn('actions', function ($user) {
                $html = '';
                $data = Auth::user()->roles[0]['permissions'];
                $isAllowUpdate = collect($data)->contains('name', 'cars.update');
                $isAllowDelete = collect($data)->contains('name', 'cars.delete');

                if ($isAllowUpdate) {
                    $html .= "<a href='" . route('cars.update') . "?id=" . $user['id'] . "' class='btn m-1 btn-primary'>Update</a>";
                }
                if ($isAllowDelete) {
                    $html .= "<a href='" . route('cars.delete') . "?id=" . $user['id'] . "' class='btn m-1 btn-danger'>Delete</a>";
                }

                return $html;
            })->rawColumns(['actions'])->make(true);
        }
        return view('cars.index');
    }
    function createView(Request $request)
    {
        return view('cars.create');
    }
    function create(Request $request)
    {
        $data = $request->input();
        $book = new Car();
        $book->name = $data['name'];
        $book->save();

        $request->session()->flash('modal-title', 'Berhasil');
        $request->session()->flash('modal-text', 'Data berhasil dibuat');
        $request->session()->flash('modal-icon', 'success');

        return redirect()->route('cars.index');
    }
    function updateView(Request $request)
    {
        $data = $request->input();
        $find = Car::find($data['id']);

        if (!isset($find)) {
            $request->session()->flash('modal-title', 'Gagal');
            $request->session()->flash('modal-text', 'Data tidak ditemukan');
            $request->session()->flash('modal-icon', 'error');
            return redirect()->route('books.index');
        }
        return view('cars.update', ['data' => $find]);
    }
    function update(Request $request)
    {
        $data = $request->input();
        $find = Car::find($data['id']);

        if (!isset($find)) {
            $request->session()->flash('modal-title', 'Gagal');
            $request->session()->flash('modal-text', 'Data tidak ditemukan');
            $request->session()->flash('modal-icon', 'error');
            return redirect()->route('cars.index');
        }

        $find->name = $data['name'];
        $find->save();

        $request->session()->flash('modal-title', 'Berhasil');
        $request->session()->flash('modal-text', 'Data berhasil diubah');
        $request->session()->flash('modal-icon', 'success');

        return redirect()->route('cars.index');
    }
    function delete(Request $request)
    {
        $data = $request->input();
        $find = Car::find($data['id']);

        if (!isset($find)) {
            $request->session()->flash('modal-title', 'Gagal');
            $request->session()->flash('modal-text', 'Data tidak ditemukan');
            $request->session()->flash('modal-icon', 'error');
            return redirect()->route('books.index');
        }

        $find->delete();

        $request->session()->flash('modal-title', 'Berhasil');
        $request->session()->flash('modal-text', 'Data berhasil dihapus');
        $request->session()->flash('modal-icon', 'success');

        return redirect()->route('cars.index');
    }

    function exportView(Request $request)
    {
        if ($request->ajax()) {
            $data = Export::query();
            return DataTables::of($data)->addColumn('actions', function ($item) {
                $html = "";
                if ($item['status'] == "completed") {
                    $html = '<a href="' . route('cars.export.download', ["path" => $item['path']]) . '"class="btn btn-primary">Download</button>';
                }

                return $html;
            })->rawColumns(['actions'])->make(true);
        }
        return view('export.index');
    }

    function export(Request $request)
    {
        $data = Carbon::now()->format('Y-m-d H:i:s.u');
        $fileName = "test-dummy-" . $data . ".xlsx";
        $export = Export::create([
            "path" => $fileName
        ]);
        $car = (new CarsExport($export))->queue($fileName, "public")->chain([
            new UpdateExportStatusToCompleted($export),
        ]);

        $request->session()->flash('modal-title', 'Berhasil');
        $request->session()->flash('modal-text', 'Data berhasil diexport');
        $request->session()->flash('modal-icon', 'success');

        return redirect()->route('cars.export.index');
    }

    function exportDownload(Request $request)
    {
        return Storage::download("public/" . $request->input()['path']);
    }
}
