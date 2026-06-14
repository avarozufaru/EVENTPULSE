@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0"><i class="bi bi-plus-circle-fill me-2" style="color: #a78bfa;"></i>Tambah Event</h2>
                <a href="/events" class="btn btn-outline-secondary" style="border-radius: 10px;">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card glass-box border-0 shadow-lg p-0">
                <div class="card-body p-4 p-md-5">
                    <form action="/events" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label"><i class="bi bi-tags-fill me-1 text-primary"></i> Kategori</label>
                                <select name="category_id" class="form-select form-select-lg" required style="border-radius: 12px;">
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-type me-1 text-primary"></i> Judul Event</label>
                                <input type="text" name="judul" class="form-control form-control-lg" placeholder="Contoh: Seminar Teknologi Masa Depan" required style="border-radius: 12px;">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-file-text-fill me-1 text-primary"></i> Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="5" placeholder="Tuliskan deskripsi lengkap mengenai event ini..." required style="border-radius: 12px; resize: none;"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-person-video3 me-1 text-primary"></i> Pembicara <span class="text-muted fs-6">(Opsional)</span></label>
                            <input type="text" name="pembicara" class="form-control form-control-lg" placeholder="Nama pembicara atau narasumber" style="border-radius: 12px;">
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label"><i class="bi bi-calendar-date-fill me-1 text-primary"></i> Tanggal</label>
                                <input type="date" name="tanggal" class="form-control form-control-lg" required style="border-radius: 12px;">
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label"><i class="bi bi-clock-fill me-1 text-primary"></i> Jam Mulai</label>
                                <input type="time" name="jam_mulai" class="form-control form-control-lg" required style="border-radius: 12px;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><i class="bi bi-clock me-1 text-primary"></i> Jam Selesai <span class="text-muted fs-6">(Opsional)</span></label>
                                <input type="time" name="jam_selesai" class="form-control form-control-lg" style="border-radius: 12px;">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-geo-alt-fill me-1 text-primary"></i> Lokasi</label>
                            <input type="text" name="lokasi" class="form-control form-control-lg" placeholder="Contoh: Aula Utama Kampus A / Link Zoom" required style="border-radius: 12px;">
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label"><i class="bi bi-people-fill me-1 text-primary"></i> Kuota</label>
                                <input type="number" name="kuota" class="form-control form-control-lg" value="100" min="1" required style="border-radius: 12px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-cash-coin me-1 text-primary"></i> Harga (0 = Gratis)</label>
                                <div class="input-group input-group-lg" style="border-radius: 12px; overflow: hidden;">
                                    <span class="input-group-text border-0" style="background: rgba(255,255,255,0.1); color: #e2e8f0;">Rp</span>
                                    <input type="number" name="harga" class="form-control border-0" value="0" min="0" style="background: rgba(255,255,255,0.06);">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-image-fill me-1 text-primary"></i> Banner / Poster Event <span class="text-muted fs-6">(Opsional)</span></label>
                            <div class="p-4 rounded text-center mb-2" style="background: rgba(255,255,255,0.03); border: 2px dashed rgba(255,255,255,0.15); border-radius: 12px;">
                                <i class="bi bi-cloud-arrow-up-fill fs-1 text-muted mb-2 d-block"></i>
                                <span class="text-muted d-block mb-3">Unggah gambar banner event</span>
                                <input type="file" name="banner" class="form-control mx-auto" accept="image/*" onchange="previewBanner(event)" style="border-radius: 10px; max-width: 350px;">
                            </div>
                            <div id="banner-preview" class="mt-3 text-center" style="display:none;">
                                <p class="text-warning small mb-2"><i class="bi bi-eye-fill me-1"></i>Preview banner:</p>
                                <img id="preview-img" src="" alt="Preview" class="shadow-sm" style="max-height:200px; border-radius:12px; object-fit:cover; width:100%; max-width: 400px; border: 2px solid rgba(255,255,255,0.2);">
                            </div>
                        </div>

                        <div class="mb-5 bg-dark bg-opacity-25 p-3 rounded" style="border-left: 4px solid #a78bfa;">
                            <div class="form-check form-switch d-flex align-items-center gap-2">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_featured" value="1" id="isFeatured" style="transform: scale(1.3); cursor: pointer;">
                                <label class="form-check-label text-light ms-2" for="isFeatured" style="cursor: pointer; padding-top: 3px;">
                                    Tampilkan sebagai <strong>Event Unggulan</strong> di Beranda
                                </label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary-gradient btn-lg py-3" style="border-radius: 12px; font-size: 1.1rem; letter-spacing: 0.5px;">
                                <i class="bi bi-check-circle-fill me-2"></i> Simpan Event
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