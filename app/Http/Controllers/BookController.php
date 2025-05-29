<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class BookController extends Controller
{
    function indexView(Request $request)
    {
        if ($request->ajax()) {
            $data = Book::query();
            return DataTables::of($data)->addColumn('actions', function ($user) {
                $html = '';
                $data = Auth::user()->roles[0]['permissions'];
                $isAllowUpdate = collect($data)->contains('name', 'books.update');
                $isAllowDelete = collect($data)->contains('name', 'books.delete');

                if ($isAllowUpdate) {
                    $html .= "<a href='" . route('books.update') . "?id=" . $user['id'] . "' class='btn m-1 btn-primary'>Update</a>";
                }
                if ($isAllowDelete) {
                    $html .= "<a href='" . route('books.delete') . "?id=" . $user['id'] . "' class='btn m-1 btn-danger'>Delete</a>";
                }

                return $html;
            })->rawColumns(['actions'])->make(true);
        }

        return view('books.index');
    }
    function createView(Request $request)
    {
        return view('books.create');
    }
    function create(Request $request)
    {
        $data = $request->input();
        $book = new Book();
        $book->name = $data['name'];
        $book->save();

        $request->session()->flash('modal-title', 'Berhasil');
        $request->session()->flash('modal-text', 'Data berhasil dibuat');
        $request->session()->flash('modal-icon', 'success');

        return redirect()->route('books.index');
    }
    function updateView(Request $request)
    {
        $data = $request->input();
        $find = Book::find($data['id']);

        if (!isset($find)) {
            $request->session()->flash('modal-title', 'Gagal');
            $request->session()->flash('modal-text', 'Data tidak ditemukan');
            $request->session()->flash('modal-icon', 'error');
            return redirect()->route('books.index');
        }

        return view('books.update', ['data' => $find]);
    }
    function update(Request $request)
    {
        $data = $request->input();
        $find = Book::find($data['id']);

        if (!isset($find)) {
            $request->session()->flash('modal-title', 'Gagal');
            $request->session()->flash('modal-text', 'Data tidak ditemukan');
            $request->session()->flash('modal-icon', 'error');
            return redirect()->route('books.index');
        }

        $find->name = $data['name'];
        $find->save();

        $request->session()->flash('modal-title', 'Berhasil');
        $request->session()->flash('modal-text', 'Data berhasil diubah');
        $request->session()->flash('modal-icon', 'success');

        return redirect()->route('books.index');
    }
    function delete(Request $request)
    {
        $data = $request->input();
        $find = Book::find($data['id']);

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

        return redirect()->route('books.index');
    }
}
