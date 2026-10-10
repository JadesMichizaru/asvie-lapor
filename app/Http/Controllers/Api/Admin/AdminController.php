<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reports;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboardStats()
    {
        $totalReports = Reports::count();
        $pendingReports = Reports::where("status", "menunggu")->count();
        $processReports = Reports::where("status", "diproses")->count();
        $completedReports = Reports::where("status", "selesai")->count();
        $rejectedReports = Reports::where("status", "ditolak")->count();
        $totalStaff = User::whereIn("roles", [
            "admin",
            "staff",
            "guru",
        ])->count();

        return response()->json(
            [
                "success" => true,
                "data" => [
                    "total_reports" => $totalReports,
                    "pending_reports" => $pendingReports,
                    "process_reports" => $processReports,
                    "completed_reports" => $completedReports,
                    "rejected_reports" => $rejectedReports,
                    "total_staff" => $totalStaff,
                ],
            ],
            200,
        );
    }

    public function indexStaff()
    {
        $staffs = User::whereIn("roles", ["admin", "staff", "guru"])
            ->withCount("responses")
            ->latest()
            ->get();

        return response()->json(
            [
                "success" => true,
                "data" => $staffs,
            ],
            200,
        );
    }

    public function storeStaff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "roles" => "required|in:admin,staff,guru",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "success" => false,
                    "errors" => $validator->errors(),
                ],
                422,
            );
        }

        $generatedEmail = Str::slug($request->name, "") . "@school.id";

        $count = User::where(
            "email",
            "like",
            Str::slug($request->name, "") . "%",
        )->count();
        if ($count > 0) {
            $generatedEmail =
                Str::slug($request->name, "") . ($count + 1) . "@school.id";
        }

        $staff = User::create([
            "name" => $request->name,
            "email" => $generatedEmail,
            "password" => Hash::make("gurupassword543"),
            "roles" => $request->roles,
        ]);

        return response()->json(
            [
                "success" => true,
                "message" => "Petugas/Guru berhasil ditambahkan",
                "data" => [
                    "user" => $staff,
                    "default_password" => "gurupassword543",
                ],
            ],
            201,
        );
    }

    public function updateStaff(Request $request, $name)
    {
        $staff = User::where("name", $name)->first();

        if (!$staff) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Petugas/Guru tidak ditemukan",
                ],
                404,
            );
        }

        $validator = Validator::make($request->all(), [
            "name" => "sometimes|string|max:255",
            "roles" => "sometimes|in:admin,staff,guru",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "success" => false,
                    "errors" => $validator->errors(),
                ],
                422,
            );
        }

        $staff->update($request->only(["name", "roles"]));

        return response()->json(
            [
                "success" => true,
                "message" => "Data petugas/guru berhasil diperbarui",
                "data" => $staff,
            ],
            200,
        );
    }

    public function destroyStaff($name)
    {
        $staff = User::whereIn("roles", ["admin", "staff", "guru"])
            ->where("name", urldecode($name))
            ->first();

        if (!$staff) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Petugas/Guru tidak ditemukan",
                ],
                404,
            );
        }

        $staff->delete();

        return response()->json(
            [
                "success" => true,
                "message" => "Akun petugas/guru berhasil dihapus",
            ],
            200,
        );
    }
}
