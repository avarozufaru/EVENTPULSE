@extends('layouts.app')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0"><i class="bi bi-pencil-square me-2" style="color: #22c55e;"></i>Edit Event</h2>
                    <a href="/events" class="btn btn-outline-secondary" style="border-radius: 10px;">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card glass-box border-0 shadow-lg p-0">
                    <div class="card-body p-4 p-md-5">
                        <form action="/events/{{ $event->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label"><i class="bi bi-tags-fill me-1" style="color: #22c55e;"></i>
                                        Kategori</label>
                                    <select name="category_id" class="form-select form-select-lg" required
                                        style="border-radius: 12px;">
                                        <option value="" disabled>-- Pilih Kategori --</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ $event->category_id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-type me-1" style="color: #22c55e;"></i> Judul
                                        Event</label>
                                    <input type="text" name="judul" class="form-control form-control-lg"
                                        value="{{ $event->judul }}" required style="border-radius: 12px;">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><i class="bi bi-file-text-fill me-1" style="color: #22c55e;"></i>
                                    Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="5" required style="border-radius: 12px; resize: none;">{{ $event->deskripsi }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><i class="bi bi-person-video3 me-1" style="color: #22c55e;"></i>
                                    Pembicara <span class="text-muted fs-6">(Opsional)</span></label>
                                <input type="text" name="pembicara" class="form-control form-control-lg"
                                    value="{{ $event->pembicara }}" style="border-radius: 12px;">
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <label class="form-label"><i class="bi bi-calendar-date-fill me-1"
                                            style="color: #22c55e;"></i> Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control form-control-lg"
                                        value="{{ $event->tanggal }}" required style="border-radius: 12px;">
                                </div>
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <label class="form-label"><i class="bi bi-clock-fill me-1" style="color: #22c55e;"></i>
                                        Jam Mulai</label>
                                    <input type="time" name="jam_mulai" class="form-control form-control-lg"
                                        value="{{ $event->jam_mulai }}" required style="border-radius: 12px;">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label"><i class="bi bi-clock me-1" style="color: #22c55e;"></i> Jam
                                        Selesai <span class="text-muted fs-6">(Opsional)</span></label>
                                    <input type="time" name="jam_selesai" class="form-control form-control-lg"
                                        value="{{ $event->jam_selesai }}" style="border-radius: 12px;">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><i class="bi bi-geo-alt-fill me-1" style="color: #22c55e;"></i>
                                    Lokasi</label>
                                <input type="text" name="lokasi" class="form-control form-control-lg"
                                    value="{{ $event->lokasi }}" required style="border-radius: 12px;">
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label"><i class="bi bi-people-fill me-1" style="color: #22c55e;"></i>
                                        Kuota</label>
                                    <input type="number" name="kuota" class="form-control form-control-lg"
                                        value="{{ $event->kuota }}" min="1" required style="border-radius: 12px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-cash-coin me-1"
                                            style="color: #22c55e;"></i> Harga (0 = Gratis)</label>
                                    <div class="input-group input-group-lg"
                                        style="border-radius: 12px; overflow: hidden;">
                                        <span class="input-group-text border-0"
                                            style="background: #f0f7ff; color: #475569;">Rp</span>
                                        <input type="number" name="harga" class="form-control border-0"
                                            value="{{ $event->harga }}" min="0" style="background: #f8fafc;">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><i class="bi bi-image-fill me-1" style="color: #22c55e;"></i>
                                    Banner / Poster Event</label>
                                @if ($event->banner)
                                    <div class="mb-3 text-center p-3 rounded"
                                        style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                        <p class="text-muted small mb-2"><i class="bi bi-info-circle me-1"></i>Banner saat
                                            ini:</p>
                                        <img src="{{ asset('storage/' . $event->banner) }}" alt="Banner"
                                            class="shadow-sm"
                                            style="max-height:200px; border-radius:12px; object-fit:cover; width:100%; max-width: 400px;">
                                    </div>
                                @endif
                                <div class="p-4 rounded text-center mb-2"
                                    style="background: #f8fafc; border: 2px dashed rgba(34, 197, 94,0.3); border-radius: 12px; position: relative;">
                                    <i class="bi bi-cloud-arrow-up-fill fs-1 mb-2 d-block" style="color: #22c55e;"></i>
                                    <span class="text-muted d-block mb-2">Pilih file baru untuk mengganti banner lama
                                        (Opsional)</span>
                                    <input type="file" name="banner" class="form-control mx-auto" accept="image/*"
                                        onchange="previewBanner(event)" style="border-radius: 10px; max-width: 350px;">
                                </div>
                                <div id="banner-preview" class="mt-3 text-center" style="display:none;">
                                    <p class="small mb-2" style="color: #22c55e;"><i
                                            class="bi bi-eye-fill me-1"></i>Preview banner baru:</p>
                                    <img id="preview-img" src="" alt="Preview" class="shadow-sm"
                                        style="max-height:200px; border-radius:12px; object-fit:cover; width:100%; max-width: 400px; border: 2px solid #e2e8f0;">
                                </div>
                            </div>

                            <div class="mb-5 p-3 rounded" style="background: #f0f7ff; border-left: 4px solid #22c55e;">
                                <div class="form-check form-switch d-flex align-items-center gap-2">
                                    <input class="form-check-input" type="checkbox" role="switch" name="is_featured"
                                        value="1" id="isFeatured" {{ $event->is_featured ? 'checked' : '' }}
                                        style="transform: scale(1.3); cursor: pointer;">
                                    <label class="form-check-label ms-2" for="isFeatured"
                                        style="cursor: pointer; padding-top: 3px; color: #1e293b;">
                                        Tampilkan sebagai <strong>Event Unggulan</strong> di Beranda
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-warning btn-lg px-5"
                                    style="border-radius: 12px; font-weight: 600; color: #0f0f1a;">
                                    <i class="bi bi-save-fill me-2"></i> Update Event
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewBanner(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('banner-preview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
