<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\Game;
use Illuminate\Validation\Rule;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::with('games')->latest()->get();
        $games = Game::all();
        
        $totalAttributes = $attributes->count();
        $activeAttributes = $attributes->where('status', 'active')->count();
        $inactiveAttributes = $attributes->where('status', 'inactive')->count();

        return view('admin.pages.cauhinhthuoctinh', compact(
            'attributes', 'games', 'totalAttributes', 'activeAttributes', 'inactiveAttributes'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'game_ids' => 'required|array',
            'game_ids.*' => 'exists:games,id',
            'type' => ['required', Rule::in(['text', 'number', 'select', 'checkbox'])],
            'options' => 'nullable|string',
            'variable_name' => 'required|string|max:255|unique:attributes,variable_name',
            'status' => ['required', Rule::in(['active', 'inactive'])]
        ]);

        $options = null;
        if ($request->type === 'select' && $request->filled('options')) {
            $options = array_map('trim', explode("\n", $request->options));
            $options = array_filter($options); // remove empty
        }

        $attribute = Attribute::create([
            'name' => $request->name,
            'variable_name' => $request->variable_name,
            'type' => $request->type,
            'options' => $options,
            'status' => $request->status
        ]);

        $attribute->games()->sync($request->game_ids);

        return response()->json(['success' => true, 'message' => 'Đã thêm thuộc tính thành công']);
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'game_ids' => 'required|array',
            'game_ids.*' => 'exists:games,id',
            'type' => ['required', Rule::in(['text', 'number', 'select', 'checkbox'])],
            'options' => 'nullable|string',
            'variable_name' => ['required', 'string', 'max:255', Rule::unique('attributes')->ignore($attribute->id)],
            'status' => ['required', Rule::in(['active', 'inactive'])]
        ]);

        $options = null;
        if ($request->type === 'select' && $request->filled('options')) {
            $options = array_map('trim', explode("\n", $request->options));
            $options = array_filter($options);
        }

        $attribute->update([
            'name' => $request->name,
            'variable_name' => $request->variable_name,
            'type' => $request->type,
            'options' => $options,
            'status' => $request->status
        ]);

        $attribute->games()->sync($request->game_ids);

        return response()->json(['success' => true, 'message' => 'Đã cập nhật thuộc tính thành công']);
    }

    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();

        return response()->json(['success' => true, 'message' => 'Đã xóa thuộc tính khỏi hệ thống!']);
    }

    public function toggleStatus($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->status = $attribute->status === 'active' ? 'inactive' : 'active';
        $attribute->save();

        return response()->json([
            'success' => true, 
            'message' => 'Đã thay đổi trạng thái thành phần cấu hình!',
            'new_status' => $attribute->status
        ]);
    }
}
