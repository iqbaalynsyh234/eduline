<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Http\Request;

class EbookController extends Controller
{
    public function index()
    {
        $ebooks = Ebook::all();
        return view('dashboard', compact('ebooks'));
    }

    public function show($id)
    {
        $ebook = Ebook::findOrFail($id);
        $filePath = asset('ebook/assesment/' . basename($ebook->file_path));  

        if (file_exists(public_path('ebook/assesment/' . basename($ebook->file_path)))) {
            return view('ebook.show', compact('ebook', 'filePath'));
        } else {
            abort(404, 'File not found');
        }
    }

    public function destroy($id)
    {
        $ebook = Ebook::findOrFail($id);
        $ebook->delete();
        return redirect()->route('dashboard');
    }
}
