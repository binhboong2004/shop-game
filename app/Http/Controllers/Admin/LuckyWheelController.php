<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LuckyWheel;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LuckyWheelController extends Controller
{
    public function index()
    {
        $wheels = LuckyWheel::with('game')->latest()->get();
        $games = Game::where('status', 1)->get();
        
        return view('admin.pages.vongquaymayman', compact('wheels', 'games'));
    }

    public function show($id)
    {
        $wheel = LuckyWheel::with(['game', 'prizes'])->findOrFail($id);
        return view('admin.pages.vongquaymayman_prizes', compact('wheel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('lucky_wheels', 'public');
        }

        LuckyWheel::create($data);

        return response()->json(['success' => true, 'message' => 'Thêm vòng quay mới thành công!']);
    }

    public function edit($id)
    {
        $wheel = LuckyWheel::findOrFail($id);
        return response()->json($wheel);
    }

    public function update(Request $request, $id)
    {
        $wheel = LuckyWheel::findOrFail($id);

        $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($wheel->image) {
                Storage::disk('public')->delete($wheel->image);
            }
            $data['image'] = $request->file('image')->store('lucky_wheels', 'public');
        }

        $wheel->update($data);

        return response()->json(['success' => true, 'message' => 'Cập nhật vòng quay thành công!']);
    }

    public function destroy($id)
    {
        $wheel = LuckyWheel::findOrFail($id);
        
        if ($wheel->image) {
            Storage::disk('public')->delete($wheel->image);
        }
        
        $wheel->delete();

        return response()->json(['success' => true, 'message' => 'Xóa vòng quay thành công!']);
    }

    public function toggleStatus($id)
    {
        $wheel = LuckyWheel::findOrFail($id);
        $wheel->status = !$wheel->status;
        $wheel->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật trạng thái thành công!', 'status' => $wheel->status]);
    }
}
