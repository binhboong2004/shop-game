<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WheelPrize;
use App\Models\LuckyWheel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WheelPrizeController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'lucky_wheel_id' => 'required|exists:lucky_wheels,id',
                'name' => 'required|string|max:255',
                'type' => 'required|string',
                'value' => 'required|numeric',
                'probability' => 'required|numeric|min:0|max:100',
                'status' => 'required|boolean',
                'image' => 'nullable|image|max:2048',
            ]);

            $data = $request->only(['lucky_wheel_id', 'name', 'type', 'value', 'probability', 'status']);

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('wheel_prizes', 'public');
            }

            WheelPrize::create($data);

            return response()->json(['success' => true, 'message' => 'Thêm phần thưởng thành công!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $prize = WheelPrize::findOrFail($id);
        return response()->json($prize);
    }

    public function update(Request $request, $id)
    {
        try {
            $prize = WheelPrize::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|string',
                'value' => 'required|numeric',
                'probability' => 'required|numeric|min:0|max:100',
                'status' => 'required|boolean',
                'image' => 'nullable|image|max:2048',
            ]);

            $data = $request->only(['name', 'type', 'value', 'probability', 'status']);

            if ($request->hasFile('image')) {
                if ($prize->image) {
                    Storage::disk('public')->delete($prize->image);
                }
                $data['image'] = $request->file('image')->store('wheel_prizes', 'public');
            }

            $prize->update($data);

            return response()->json(['success' => true, 'message' => 'Cập nhật phần thưởng thành công!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $prize = WheelPrize::findOrFail($id);
        
        if ($prize->image) {
            Storage::disk('public')->delete($prize->image);
        }
        
        $prize->delete();

        return response()->json(['success' => true, 'message' => 'Xóa phần thưởng thành công!']);
    }
}
