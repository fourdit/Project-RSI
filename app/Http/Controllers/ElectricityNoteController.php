<?php

namespace App\Http\Controllers;

use App\Models\ElectricityNote;
use App\Models\ElectricityItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ElectricityNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $filter = $request->get('filter', 'daily');
        $user = Auth::user();
        
        $query = ElectricityNote::where('user_id', $user->id)
            ->with('items')
            ->orderBy('date', 'desc');

        // Filter berdasarkan periode
        switch ($filter) {
            case 'weekly':
                $query->whereBetween('date', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                break;
            case 'monthly':
                $query->whereMonth('date', Carbon::now()->month)
                      ->whereYear('date', Carbon::now()->year);
                break;
            case 'yearly':
                $query->whereYear('date', Carbon::now()->year);
                break;
            default: // daily
                $query->whereDate('date', Carbon::today());
                break;
        }

        $notes = $query->get();
        
        // Hitung total biaya
        $totalCost = $notes->sum('total_cost');

        return view('electricity.index', compact('notes', 'filter', 'totalCost'));
    }

    public function create()
    {
        return view('electricity.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'price_per_kwh' => 'required|numeric|min:0',
            'house_power' => 'required|integer|min:0',
            'items' => 'required|array|min:1',
            'items.*.appliance_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.duration_hours' => 'required|integer|min:0|max:23',
            'items.*.duration_minutes' => 'required|integer|min:0|max:59',
            'items.*.wattage' => 'required|integer|min:0',
        ], [
            'date.required' => 'Tanggal harus diisi',
            'price_per_kwh.required' => 'Harga per kWh harus diisi',
            'house_power.required' => 'Daya listrik rumah harus diisi',
            'items.required' => 'Minimal satu alat harus diisi',
            'items.*.appliance_name.required' => 'Nama alat harus diisi',
            'items.*.quantity.required' => 'Jumlah alat harus diisi',
            'items.*.duration_hours.required' => 'Durasi jam harus diisi',
            'items.*.duration_minutes.required' => 'Durasi menit harus diisi',
            'items.*.wattage.required' => 'Daya alat harus diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $totalCost = 0;

            // Buat catatan utama
            $note = ElectricityNote::create([
                'user_id' => Auth::id(),
                'date' => $request->date,
                'price_per_kwh' => $request->price_per_kwh,
                'house_power' => $request->house_power,
                'total_cost' => 0, // akan diupdate setelah hitung items
            ]);

            // Simpan items dan hitung total biaya
            foreach ($request->items as $item) {
                $hours = $item['duration_hours'] + ($item['duration_minutes'] / 60);
                $kwh = ($item['wattage'] * $item['quantity'] * $hours) / 1000;
                $cost = $kwh * $request->price_per_kwh;
                
                ElectricityItem::create([
                    'note_id' => $note->id,
                    'appliance_name' => $item['appliance_name'],
                    'quantity' => $item['quantity'],
                    'duration_hours' => $item['duration_hours'],
                    'duration_minutes' => $item['duration_minutes'],
                    'wattage' => $item['wattage'],
                    'cost' => $cost,
                ]);

                $totalCost += $cost;
            }

            // Update total cost
            $note->update(['total_cost' => $totalCost]);

            DB::commit();

            return redirect()->route('electricity-notes.index')
                ->with('success', 'Catatan listrik berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}