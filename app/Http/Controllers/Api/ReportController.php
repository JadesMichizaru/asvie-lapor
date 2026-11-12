<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function index()
    {
        $reports = \App\Models\Reports::with('user')->latest()->get();
        return response()->json([
            "success" => true,
            "data" => $reports
        ], 200);
    }

    public function showStatus($status)
    {
        $count = Reports::where("status", $status)->count();

        return response()->json(
            [
                "success" => true,
                "message" => "Jumlah laporan dengan status '{$status}'",
                "data" => [
                    "status" => $status,
                    "total" => $count,
                ],
            ],
            200,
        );
    }

    public function show($title)
    {
        $report = Reports::where("title", $title)->first();
        if (!$report) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Laporan tidak ditemukan",
                ],
                404,
            );
        }

        return response()->json(
            [
                "success" => true,
                "data" => $report,
            ],
            200,
        );
    }

    public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                "title" => "required|string|max:150",
                "description" => "required|string",
                "location" => "required|string",
                "category" =>
                    "required|in:merokok,tawuran,merusak_fasilitas,buang_sampah_sembarangan,membuat_kegaduhan,parkir_sembarangan,lainnya",
                "is_anonymous" => "nullable|boolean",
                "evidence_file" => "nullable|image|mimes:png,jpg,jpeg,webp|max:2048",
            ], [
                "evidence_file.image" => "Lampiran harus berupa file gambar.",
                "evidence_file.mimes" => "Format gambar harus JPG, JPEG, PNG, atau WEBP.",
                "evidence_file.max" => "Ukuran gambar maksimal adalah 2MB agar tidak memberatkan server.",
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => $validator->errors()->first(),
                        "errors" => $validator->errors(),
                    ],
                    422,
                );
            }

            // Di dalam method store() menggantikan ->store("evidence_files", "public"):
            $evidenceFilePath = null;
            if ($request->hasFile("evidence_file")) {
                $file = $request->file("evidence_file");
                $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
                $supabaseKey = env('SUPABASE_SERVICE_KEY');

                $uploadResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $supabaseKey,
                    'apikey' => $supabaseKey,
                    'Content-Type' => $file->getMimeType(),
                ])->withBody(
                    file_get_contents($file->getRealPath()),
                    $file->getMimeType()
                )->post("{$supabaseUrl}/storage/v1/object/evidence/{$fileName}");

                if ($uploadResponse->successful()) {
                    $evidenceFilePath = "{$supabaseUrl}/storage/v1/object/public/evidence/{$fileName}";
                }
            }

            $userId = $request->user() ? $request->user()->id : $request->user_id;

            $report = Reports::create([
                "user_id" => $userId,
                "title" => $request->title,
                "description" => $request->description,
                "location" => $request->location,
                "category" => $request->category,
                "status" => "menunggu",
                "is_anonymous" => $request->boolean("is_anonymous", false),
                "evidence_image" => $evidenceFilePath,
            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Laporan berhasil dibuat",
                    "data" => $report,
                ],
                201,
            );
        }

    public function update(Request $request, $title)
    {
        $user = $request->user();
        if (!$user || !in_array($user->roles, ["admin", "guru"])) {
            return response()->json(
                [
                    "success" => false,
                    "message" =>
                        "Akses ditolak. Hanya Admin atau Staff yang dapat memperbarui status laporan.",
                ],
                403,
            );
        }

        $validator = Validator::make($request->all(), [
            "status" => "required|in:menunggu,diproses,selesai,ditolak",
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

        $report = Reports::where("title", $title)->first();

        if (!$report) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Laporan tidak ditemukan",
                ],
                404,
            );
        }

        $report->update([
            "status" => $request->status,
        ]);

        return response()->json(
            [
                "success" => true,
                "message" => "Status laporan berhasil diperbarui",
                "data" => $report,
            ],
            200,
        );
    }

    public function destroy($title)
    {
        $report = Reports::where("title", $title)->first();

        if (!$report) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Laporan tidak ditemukan",
                ],
                404,
            );
        }

        $report->delete();

        return response()->json(
            [
                "success" => true,
                "message" => "Laporan berhasil dihapus",
            ],
            200,
        );
    }
}
