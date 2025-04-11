<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerRequest;
use App\Models\Player\Players;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Bắt buộc đăng nhập để truy cập controller này.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Hiển thị danh sách cầu thủ.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $players = Players::all(); // Lấy danh sách cầu thủ từ database
        return view('player.index', compact('players'));
    }

    /**
     * Hiển thị form thêm cầu thủ mới.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('player.create');
    }

    /**
     * Lưu cầu thủ mới vào database.
     *
     *
     */
    public function store(PlayerRequest $request)
    {
        Players::create($request->validated());

        return redirect()->route('player.index')->with('success', 'Thêm cầu thủ thành công!');
    }

    /**
     * Hiển thị chi tiết một cầu thủ.
     *
     *
     */
    public function show(string $id)
    {
        $player = Players::findOrFail($id);
        return view('player.show', compact('player'));
    }

    /**
     * Hiển thị form chỉnh sửa cầu thủ.
     *
     */
    public function edit(string $id)
    {
        $player = Players::findOrFail($id);
        return view('player.edit', compact('player'));
    }

    /**
     * Cập nhật thông tin cầu thủ.
     *
     * 
     */
    public function update(PlayerRequest $request, string $id)
    {
        $player = Players::findOrFail($id);
        $player->update($request->validated());

        return redirect()->route('player.index')->with('success', 'Cập nhật cầu thủ thành công!');
    }

    /**
     * Xóa cầu thủ khỏi hệ thống.
     *
     */
    public function destroy(string $id)
    {
        $player = Players::findOrFail($id);
        $player->delete();

        return redirect()->route('player.index')->with('success', 'Xóa cầu thủ thành công!');
    }
}
