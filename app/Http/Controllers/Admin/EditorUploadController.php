<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\ImageUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Upload gambar dari dalam WYSIWYG editor (TinyMCE images_upload_handler).
 * Respons: { "location": "<url gambar>" }.
 */
class EditorUploadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate(
            ['file' => 'required|' . ImageUpload::RULE],
            ImageUpload::messages('file') + ['file.required' => 'Pilih gambar yang akan diunggah.']
        );

        $path = $request->file('file')->store('editor', 'public');

        return response()->json(['location' => ImageUpload::url($path)]);
    }
}
