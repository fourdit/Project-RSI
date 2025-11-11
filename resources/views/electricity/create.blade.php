@extends('layouts.app')

@section('title', 'Membuat Catatan - ZENERGY')

@section('content')
<div class="create-note-container">
    <div class="create-note-header">
        <a href="{{ route('electricity-notes.index') }}" class="back-button">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <h1>Membuat Catatan</h1>
    </div>

    <form method="POST" action="{{ route('electricity-notes.store') }}" id="note-form" class="note-form">
        @csrf

        <div class="form-top-section">
            <div class="form-row">
                <div class="form-group">
                    <label for="date">Tanggal</label>
                    <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                    @error('date')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price_per_kwh">Harga per kWh</label>
                    <input type="number" id="price_per_kwh" name="price_per_kwh" value="{{ old('price_per_kwh') }}" step="0.01" required>
                    @error('price_per_kwh')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="house_power">Daya listrik rumah</label>
                    <div class="input-with-unit">
                        <input type="number" id="house_power" name="house_power" value="{{ old('house_power') }}" required>
                        <span class="unit">VA</span>
                    </div>
                    @error('house_power')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div id="items-container">
            @if(old('items'))
                @foreach(old('items') as $index => $item)
                    <div class="item-box" data-index="{{ $index }}">
                        <button type="button" class="remove-item" onclick="removeItem(this)">×</button>
                        
                        <div class="item-box-header">
                            <div class="form-group">
                                <label>Nama Alat</label>
                                <input type="text" name="items[{{ $index }}][appliance_name]" value="{{ $item['appliance_name'] ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="number" name="items[{{ $index }}][quantity]" value="{{ $item['quantity'] ?? '' }}" min="1" required>
                            </div>
                        </div>

                        <div class="item-box-body">
                            <div class="form-group">
                                <label>Durasi</label>
                                <div class="duration-inputs">
                                    <input type="number" name="items[{{ $index }}][duration_hours]" value="{{ $item['duration_hours'] ?? '' }}" min="0" max="23" placeholder="Jam" required>
                                    <span>:</span>
                                    <input type="number" name="items[{{ $index }}][duration_minutes]" value="{{ $item['duration_minutes'] ?? '' }}" min="0" max="59" placeholder="Menit" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Daya alat</label>
                                <div class="input-with-unit">
                                    <input type="number" name="items[{{ $index }}][wattage]" value="{{ $item['wattage'] ?? '' }}" min="0" required>
                                    <span class="unit">watt</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="item-box" data-index="0">
                    <button type="button" class="remove-item" onclick="removeItem(this)">×</button>
                    
                    <div class="item-box-header">
                        <div class="form-group">
                            <label>Nama Alat</label>
                            <input type="text" name="items[0][appliance_name]" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" name="items[0][quantity]" min="1" value="1" required>
                        </div>
                    </div>

                    <div class="item-box-body">
                        <div class="form-group">
                            <label>Durasi</label>
                            <div class="duration-inputs">
                                <input type="number" name="items[0][duration_hours]" min="0" max="23" placeholder="Jam" value="0" required>
                                <span>:</span>
                                <input type="number" name="items[0][duration_minutes]" min="0" max="59" placeholder="Menit" value="0" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Daya alat</label>
                            <div class="input-with-unit">
                                <input type="number" name="items[0][wattage]" min="0" required>
                                <span class="unit">watt</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <button type="button" class="btn btn-add-item" onclick="addItem()">+</button>

        <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
    </form>
</div>

<script>
let itemIndex = {{ old('items') ? count(old('items')) : 1 }};

function addItem() {
    const container = document.getElementById('items-container');
    const newItem = document.createElement('div');
    newItem.className = 'item-box';
    newItem.setAttribute('data-index', itemIndex);
    
    newItem.innerHTML = `
        <button type="button" class="remove-item" onclick="removeItem(this)">×</button>
        
        <div class="item-box-header">
            <div class="form-group">
                <label>Nama Alat</label>
                <input type="text" name="items[${itemIndex}][appliance_name]" required>
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="items[${itemIndex}][quantity]" min="1" value="1" required>
            </div>
        </div>

        <div class="item-box-body">
            <div class="form-group">
                <label>Durasi</label>
                <div class="duration-inputs">
                    <input type="number" name="items[${itemIndex}][duration_hours]" min="0" max="23" placeholder="Jam" value="0" required>
                    <span>:</span>
                    <input type="number" name="items[${itemIndex}][duration_minutes]" min="0" max="59" placeholder="Menit" value="0" required>
                </div>
            </div>
            <div class="form-group">
                <label>Daya alat</label>
                <div class="input-with-unit">
                    <input type="number" name="items[${itemIndex}][wattage]" min="0" required>
                    <span class="unit">watt</span>
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(newItem);
    itemIndex++;
}

function removeItem(button) {
    const itemBox = button.closest('.item-box');
    const container = document.getElementById('items-container');
    
    // Minimal harus ada 1 item
    if (container.children.length > 1) {
        itemBox.remove();
    } else {
        alert('Minimal harus ada satu alat!');
    }
}
</script>
@endsection