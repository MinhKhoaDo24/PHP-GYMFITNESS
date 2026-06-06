<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $q = $request->input('q');
        
        $query = Size::query();

        if ($status !== null && $status !== '') {
            $query->where('trang_thai', $status);
        }

        if ($q) {
            $query->where(function($subQuery) use ($q) {
                $subQuery->where('ten_size', 'like', "%{$q}%")
                         ->orWhere('mota', 'like', "%{$q}%");
            });
        }

        $sizes = $query->orderBy('id_size', 'DESC')->get();

        return view('admin.sizes.index', compact('sizes', 'q', 'status'));
    }

    public function create()
    {
        return view('admin.sizes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_size' => 'required|max:50|unique:size,ten_size',
            'mota'     => 'nullable|max:255',
        ], [
            'ten_size.required' => 'Tên size không được để trống.',
            'ten_size.max'      => 'Tên size không được quá 50 ký tự.',
            'ten_size.unique'   => 'Tên size này đã tồn tại.',
            'mota.max'          => 'Mô tả không được quá 255 ký tự.',
        ]);

        Size::create($request->all());

        return redirect()->route('sizes.index')->with('success', 'Thêm size thành công!');
    }

    public function edit($id)
    {
        $size = Size::findOrFail($id);
        return view('admin.sizes.edit', compact('size'));
    }

    public function update(Request $request, $id)
    {
        $size = Size::findOrFail($id);

        $request->validate([
            'ten_size' => 'required|max:50|unique:size,ten_size,' . $id . ',id_size',
            'mota'     => 'nullable|max:255',
        ], [
            'ten_size.required' => 'Tên size không được để trống.',
            'ten_size.max'      => 'Tên size không được quá 50 ký tự.',
            'ten_size.unique'   => 'Tên size này đã tồn tại.',
            'mota.max'          => 'Mô tả không được quá 255 ký tự.',
        ]);

        $size->update($request->all());

        return redirect()->route('sizes.index')->with('success', 'Cập nhật size thành công!');
    }

    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->trang_thai = 0;
        $size->save();

        return redirect()->route('sizes.index')->with('success', 'Size đã được vô hiệu hóa thành công.');
    }

    public function restore($id)
    {
        $size = Size::findOrFail($id);
        $size->trang_thai = 1;
        $size->save();

        return redirect()->route('sizes.index')->with('success', 'Khôi phục size thành công.');
    }
}
