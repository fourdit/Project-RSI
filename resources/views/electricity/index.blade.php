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
                <div class="note-card">
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

<script>
let currentDate = new Date();

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
</script>
@endsection