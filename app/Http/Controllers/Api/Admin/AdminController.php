<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotResponses;
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
            "roles" => "required|in:admin,staff,guru,siswa,warga",
            "nik" => "required_if:roles,siswa|nullable|string",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "errors" => $validator->errors()
            ], 422);
        }

        // Otomatisasi generate Email dari Nama Lengkap
        $baseSlug = Str::slug($request->name, "");
        $generatedEmail = $baseSlug . "@school.id";
        $count = User::where("email", "like", $baseSlug . "%")->count();

        if ($count > 0) {
            $generatedEmail = $baseSlug . ($count + 1) . "@school.id";
        }

        // Otomatisasi generate Password berdasarkan Role & NIK
        $defaultPassword = "gurupassword543";
        if ($request->roles === "siswa") {
            $defaultPassword = "siswa" . ($request->nik ?? "123");
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $generatedEmail,
            "password" => Hash::make($defaultPassword),
            "roles" => $request->roles,
            "nik" => $request->nik,
        ]);

        return response()->json([
            "success" => true,
            "message" => "Akun berhasil ditambahkan",
            "data" => [
                "user" => $user,
                "default_password" => $defaultPassword,
                "generated_email" => $generatedEmail
            ],
        ], 201);
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
            // Ubah query agar Admin bisa menghapus role apa saja dari dashboard
            $user = User::where("name", urldecode($name))->first();

            if (!$user) {
                return response()->json(["success" => false, "message" => "Akun tidak ditemukan"], 404);
            }

            $user->delete();
            return response()->json(["success" => true, "message" => "Akun berhasil dihapus"], 200);
        }

    // Chatbot CRUD
    //

    public function indexChatbot()
    {
        $data = ChatbotResponses::with('creator:id,name')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }

    public function storeChatbot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'required|string|unique:chatbot_responses,keyword',
            'response' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $chatbot = ChatbotResponses::create([
            'keyword' => strtolower(trim($request->keyword)),
            'response' => $request->response,
            'created_by' => $request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Keyword chatbot berhasil ditambahkan',
            'data' => $chatbot,
        ], 201);
    }

    public function updateChatbot(Request $request, $id)
    {
        $chatbot = ChatbotResponses::find($id);

        if (!$chatbot) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'keyword' => 'sometimes|string|unique:chatbot_responses,keyword,' . $id,
            'response' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->only(['response']);
        if ($request->has('keyword')) {
            $data['keyword'] = strtolower(trim($request->keyword));
        }

        $chatbot->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data chatbot berhasil diperbarui',
            'data' => $chatbot,
        ], 200);
    }

    public function destroyChatbot($id)
    {
        $chatbot = ChatbotResponses::find($id);

        if (!$chatbot) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $chatbot->delete();

        return response()->json([
            'success' => true,
            'message' => 'Keyword chatbot berhasil dihapus',
        ], 200);
    }
}
