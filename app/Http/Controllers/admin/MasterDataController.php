<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassStatus;
use App\Models\ClassMemberStatus;
use App\Models\MaterialType;
use App\Models\Role;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function index()
    {
        $classStatuses = ClassStatus::all();
        $memberStatuses = ClassMemberStatus::all();
        $materialTypes = MaterialType::all();
        $roles = Role::all();

        return view('admin.master', compact(
            'classStatuses',
            'memberStatuses',
            'materialTypes',
            'roles'
        ));
    }

    // Class Status
    public function storeClassStatus(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:class_statuses,name'
        ]);

        ClassStatus::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Status kelas berhasil ditambahkan'
        ]);
    }

    public function updateClassStatus(Request $request, $id)
    {
        $status = ClassStatus::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:class_statuses,name,' . $id
        ]);

        $status->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Status kelas berhasil diupdate'
        ]);
    }

    public function destroyClassStatus($id)
    {
        $status = ClassStatus::findOrFail($id);

        if ($status->classes()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus status yang sedang digunakan'
            ], 422);
        }

        $status->delete();

        return response()->json([
            'success' => true,
            'message' => 'Status kelas berhasil dihapus'
        ]);
    }

    // Member Status
    public function storeMemberStatus(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:class_member_statuses,name'
        ]);

        ClassMemberStatus::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Status anggota berhasil ditambahkan'
        ]);
    }

    public function updateMemberStatus(Request $request, $id)
    {
        $status = ClassMemberStatus::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:class_member_statuses,name,' . $id
        ]);

        $status->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Status anggota berhasil diupdate'
        ]);
    }

    public function destroyMemberStatus($id)
    {
        $status = ClassMemberStatus::findOrFail($id);

        if ($status->classMembers()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus status yang sedang digunakan'
            ], 422);
        }

        $status->delete();

        return response()->json([
            'success' => true,
            'message' => 'Status anggota berhasil dihapus'
        ]);
    }

    // Material Type
    public function storeMaterialType(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_types,name'
        ]);

        MaterialType::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tipe materi berhasil ditambahkan'
        ]);
    }

    public function updateMaterialType(Request $request, $id)
    {
        $type = MaterialType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:material_types,name,' . $id
        ]);

        $type->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tipe materi berhasil diupdate'
        ]);
    }

    public function destroyMaterialType($id)
    {
        $type = MaterialType::findOrFail($id);

        if ($type->materials()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus tipe yang sedang digunakan'
            ], 422);
        }

        $type->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tipe materi berhasil dihapus'
        ]);
    }

    // Role
    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name'
        ]);

        Role::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Role berhasil ditambahkan'
        ]);
    }

    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id
        ]);

        $role->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Role berhasil diupdate'
        ]);
    }

    public function destroyRole($id)
    {
        $role = Role::findOrFail($id);

        if ($role->users()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus role yang sedang digunakan'
            ], 422);
        }

        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role berhasil dihapus'
        ]);
    }
}