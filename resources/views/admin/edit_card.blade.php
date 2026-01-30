@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 2rem; padding-bottom: 2rem;">
    <h2
        style="margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem; color: var(--text-main);">
        Edit Proyek</h2>

    <div
        style="background: white; padding: 2rem; border-radius: 16px; border: 1px solid var(--border-color); max-width: 600px; margin: 0 auto; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <form action="{{ route('dashboard.updateCard', $card->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Judul</label>
                <input type="text" name="title" value="{{ old('title', $card->title) }}"
                    style="width: 100%; padding: 0.75rem; background: #f8fafc; border: 1px solid var(--border-color); color: var(--text-main); border-radius: 8px;"
                    required>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Deskripsi</label>
                <textarea name="description" rows="4"
                    style="width: 100%; padding: 0.75rem; background: #f8fafc; border: 1px solid var(--border-color); color: var(--text-main); border-radius: 8px;"
                    required>{{ old('description', $card->description) }}</textarea>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Gambar Terbaru</label>
                @if($card->image)
                <img src="{{ $card->image }}" alt="Current Image"
                    style="max-width: 100%; height: auto; border-radius: 8px; margin-bottom: 1rem;">
                @else
                <p style="color: var(--text-muted); margin-bottom: 1rem;">No image uploaded.</p>
                @endif

                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted);">Upload Gambar Baru (Max
                    2MB)</label>
                <input type="file" name="image" accept="image/*"
                    style="width: 100%; padding: 0.75rem; background: #f8fafc; border: 1px solid var(--border-color); color: var(--text-main); border-radius: 8px;">
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit"
                    style="background: var(--primary); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; cursor: pointer; flex: 1;">Update
                    Card</button>
                <a href="{{ route('dashboard') }}"
                    style="background: transparent; border: 1px solid var(--border-color); color: var(--text-muted); padding: 0.75rem 1.5rem; border-radius: 6px; text-align: center; text-decoration: none; flex: 1;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
