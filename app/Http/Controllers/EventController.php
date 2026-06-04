<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        if (Session::get('role') === 'penyelenggara') {
            $events = DB::table('events')->where('user_id', Session::get('id'))->get();
        } else {
            $events = DB::table('events')->get();
        }
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
    $categories = DB::table('categories')->get();
    return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
    $bannerPath = null;
    if ($request->hasFile('banner')) {
        $bannerPath = $request->file('banner')->store('banners', 'public');
    }

    DB::table('events')->insert([
        'category_id' => $request->category_id,
        'user_id'     => Session::get('id'),
        'judul'       => $request->judul,
        'slug'        => \Illuminate\Support\Str::slug($request->judul),
        'deskripsi'   => $request->deskripsi,
        'pembicara'   => $request->pembicara,
        'tanggal'     => $request->tanggal,
        'jam_mulai'   => $request->jam_mulai,
        'jam_selesai' => $request->jam_selesai,
        'lokasi'      => $request->lokasi,
        'kuota'       => $request->kuota,
        'harga'       => $request->harga ?? 0,
        'banner'      => $bannerPath,
        'is_featured' => $request->has('is_featured') ? 1 : 0,
        'status'      => Session::get('role') === 'admin' ? 'published' : 'pending',
        'created_at'  => now(),
    ]);
    return redirect('/events')->with('success', 'Event berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $event = DB::table('events')->where('id', $id)->first();
        if (!$event) {
            abort(404);
        }
        if (Session::get('role') === 'penyelenggara' && $event->user_id !== Session::get('id')) {
            return redirect('/events')->with('error', 'Anda tidak memiliki hak akses untuk mengedit event ini.');
        }
        $categories = DB::table('categories')->get();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $event = DB::table('events')->where('id', $id)->first();
        if (!$event) {
            abort(404);
        }
        if (Session::get('role') === 'penyelenggara' && $event->user_id !== Session::get('id')) {
            return redirect('/events')->with('error', 'Anda tidak memiliki hak akses untuk mengubah event ini.');
        }

        $bannerPath = $event->banner;
        if ($request->hasFile('banner')) {
            // Delete old banner if exists
            if ($bannerPath) {
                Storage::disk('public')->delete($bannerPath);
            }
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        DB::table('events')->where('id', $id)->update([
            'category_id' => $request->category_id,
            'judul'       => $request->judul,
            'slug'        => \Illuminate\Support\Str::slug($request->judul),
            'deskripsi'   => $request->deskripsi,
            'pembicara'   => $request->pembicara,
            'tanggal'     => $request->tanggal,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'lokasi'      => $request->lokasi,
            'kuota'       => $request->kuota,
            'harga'       => $request->harga ?? 0,
            'banner'      => $bannerPath,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'updated_at'  => now(),
        ]);
        return redirect('/events')->with('success', 'Event berhasil diupdate!');
    }

    public function destroy($id)
    {
        $event = DB::table('events')->where('id', $id)->first();
        if (!$event) {
            abort(404);
        }
        if (Session::get('role') === 'penyelenggara' && $event->user_id !== Session::get('id')) {
            return redirect('/events')->with('error', 'Anda tidak memiliki hak akses untuk menghapus event ini.');
        }

        DB::table('events')->where('id', $id)->delete();
        return redirect('/events')->with('success', 'Event berhasil dihapus!');
    }
}