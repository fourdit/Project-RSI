@extends('layouts.app')

@section('title', 'Catatan Listrik - ZENERGY')

@section('content')
<div class="electricity-container">
    <div class="electricity-header">
        <h1>Catatan Listrik</h1>
    </div>

    <div class="filter-section">
        <div class="filter-navigation">
            <button class="nav-arrow" onclick="changeMonth('prev')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <span class="current-month" id="current-month">Okt 2025</span>
            <button class="nav-arrow" onclick="changeMonth('next')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        <button onclick="window.location.href='{{ route('electricity-notes.create') }}'" class="btn btn-primary">
            Buat catatan
        </button>
    </div>

    <div class="filter-tabs">
        <a href="{{ route('electricity-notes.index', ['filter' => 'daily']) }}" 
           class="filter-tab {{ $filter === 'daily' ? 'active' : '' }}">
            Harian
        </a>
        <a href="{{ route('electricity-notes.index', ['filter' => 'weekly']) }}" 
           class="filter-tab {{ $filter === 'weekly' ? 'active' : '' }}">
            Mingguan
        </a>
        <a href="{{ route('electricity-notes.index', ['filter' => 'monthly']) }}" 
           class="filter-tab {{ $filter === 'monthly' ? 'active' : '' }}">
            Bulanan
        </a>
        <a href="{{ route('electricity-notes.index', ['filter' => 'yearly']) }}" 
           class="filter-tab {{ $filter === 'yearly' ? 'active' : '' }}">
            Tahunan
        </a>
    </div>

    @if($notes->isEmpty())
        <div class="empty-state">
            <p>Belum ada catatan</p>
        </div>
    @else
        <div class="total-cost-section">
            <span class="total-label">Biaya Listrik</span>
            <span class="total-amount">{{ number_format($totalCost, 0, ',', '.') }}</span>
        </div>

        <div class="notes-list">
            @foreach($notes as $note)
                <div class="note-card" onclick="showActionModal({{ $note->id }})" style="cursor: pointer;">
                    <div class="note-header">
                        <div class="note-date">
                            <span class="date-day">{{ $note->date->format('d') }}</span>
                            <span class="date-month-year">{{ $note->date->format('m.Y') }}</span>
                            <span class="date-dayname">{{ $note->date->locale('id')->isoFormat('dddd') }}</span>
                        </div>
                        <div class="note-info">
                            <span>Biaya per kWh: {{ number_format($note->price_per_kwh, 2, ',', '.') }}</span>
                            <span>Daya rumah: {{ number_format($note->house_power) }} VA</span>
                            <span class="note-total">{{ number_format($note->total_cost, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="note-items">
                        @foreach($note->items as $item)
                            <div class="item-row">
                                <span class="item-name">{{ $item->appliance_name }}</span>
                                <span class="item-detail">{{ $item->wattage }} watt</span>
                                <span class="item-detail">{{ $item->duration_hours }} jam {{ $item->duration_minutes }} menit</span>
                                <span class="item-cost">{{ number_format($item->cost, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal Action -->
<div id="actionModal" class="action-modal" style="display: none;">
    <div class="action-modal-content">
        <h3>Pilih Aksi</h3>
        <div class="action-buttons">
            <button id="editBtn" class="btn btn-edit">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M18.5 2.5C18.8978 2.10217 19.4374 1.87868 20 1.87868C20.5626 1.87868 21.1022 2.10217 21.5 2.5C21.8978 2.89782 22.1213 3.43739 22.1213 4C22.1213 4.56261 21.8978 5.10217 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Edit
            </button>
            <button id="deleteBtn" class="btn btn-delete">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 6H5H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6V20C19 20.5304 18.7893 21.0391 18.4142 21.4142C18.0391 21.7893 17.5304 22 17 22H7C6.46957 22 5.96086 21.7893 5.58579 21.4142C5.21071 21.0391 5 20.5304 5 20V6H19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Hapus
            </button>
            <button onclick="closeActionModal()" class="btn btn-cancel">Batal</button>
        </div>
    </div>
</div>

<!-- Form Delete (Hidden) -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
let currentDate = new Date();
let selectedNoteId = null;

function changeMonth(direction) {
    if (direction === 'prev') {
        currentDate.setMonth(currentDate.getMonth() - 1);
    } else {
        currentDate.setMonth(currentDate.getMonth() + 1);
    }
    
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const monthName = months[currentDate.getMonth()];
    const year = currentDate.getFullYear();
    
    document.getElementById('current-month').textContent = `${monthName} ${year}`;
}

function showActionModal(noteId) {
    selectedNoteId = noteId;
    document.getElementById('actionModal').style.display = 'flex';
    
    // Set action untuk Edit button
    document.getElementById('editBtn').onclick = function() {
        window.location.href = `/electricity-notes/${noteId}/edit`;
    };
    
    // Set action untuk Delete button
    document.getElementById('deleteBtn').onclick = function() {
        if (confirm('Apakah Anda yakin ingin menghapus catatan ini?')) {
            const form = document.getElementById('deleteForm');
            form.action = `/electricity-notes/${noteId}`;
            form.submit();
        }
    };
}

function closeActionModal() {
    document.getElementById('actionModal').style.display = 'none';
    selectedNoteId = null;
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('actionModal');
    if (event.target == modal) {
        closeActionModal();
    }
}
</script>
@endsection