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
        return view('books.index');
    }
    function create(Request $request)
    {
        return view('books.index');
    }
    function updateView(Request $request)
    {
        return view('books.index');
    }
    function update(Request $request)
    {
        return view('books.index');
    }
    function delete(Request $request)
    {
        return view('books.index');
    }
}
