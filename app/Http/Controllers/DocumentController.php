<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch the document record related to the user
        // Assuming one document record per user/customer as per schema analysis
        // Or it could be tailored if multiple docs exist, but schema suggests one 'documents' row per user/customer

        $document = Document::where('user_id', $user->id)
            ->orWhere('customer_id', $user->customer_id ?? 0)
            ->latest()
            ->first();

        return view('documents.index', compact('document', 'user'));
    }

    public function show($type)
    {
        $user = Auth::user();
        $document = Document::where('user_id', $user->id)
            ->orWhere('customer_id', $user->customer_id ?? 0)
            ->latest()
            ->first();

        if (!$document) {
            return redirect()->route('my-documents')->with('error', 'No documents found.');
        }

        $data = [];

        switch ($type) {
            case 'aadhaar':
                $data = [
                    'title' => 'Aadhaar Card',
                    'number' => $document->aadhar_card_number,
                    'image' => $document->aadhar_card_image,
                    'status' => $document->aadhar_card_image ? 'Verified' : 'Pending',
                    'updated_at' => $document->updated_at,
                    'created_at' => $document->created_at,
                    'otp_verified' => $document->aadhar_card_otp ? 'Yes' : 'No',
                ];
                break;

            case 'pan':
                $data = [
                    'title' => 'PAN Card',
                    'number' => $document->pan_card_number,
                    'image' => $document->pan_card_image,
                    'status' => $document->pan_card_image ? 'Verified' : 'Pending',
                    'updated_at' => $document->updated_at,
                    'created_at' => $document->created_at,
                    'otp_verified' => $document->pan_card_otp ? 'Yes' : 'No',
                ];
                break;

            default:
                return redirect()->route('my-documents')->with('error', 'Invalid document type.');
        }

        return view('documents.show', compact('document', 'user', 'data', 'type'));
    }

    public function serveImage($type, $filename)
    {
        $user = Auth::user();

        // Ensure user is authorized to view this file (checking ownership via Document)
        // We find the document that has this specific image filename AND belongs to the user
        $column = ($type === 'aadhaar') ? 'aadhar_card_image' : 'pan_card_image';

        $document = Document::where($column, $filename)
            ->where(function ($query) use ($user) {
                $query
                    ->where('user_id', $user->id)
                    ->orWhere('customer_id', $user->customer_id ?? 0);
            })
            ->first();

        if (!$document) {
            abort(403, 'Unauthorized access to this document.');
        }

        // Determine path
        // User specified path: storage\app\private\private_uploads\...
        $folder = ($type === 'aadhaar') ? 'private_uploads/aadhar_card' : 'private_uploads/pan_card';

        // Priority 1: Check the specific private path mentioned by user
        $path = storage_path('app/private/' . $folder . '/' . $filename);

        // Priority 2: Check the standard private_uploads path (just in case)
        if (!file_exists($path)) {
            $path = storage_path('app/' . $folder . '/' . $filename);
        }

        if (!file_exists($path)) {
            abort(404, 'File not found. Path: ' . $path);
        }

        return response()->file($path);
    }

    public function showPdf($type)
    {
        $user = Auth::user();
        $document = Document::where('user_id', $user->id)
            ->orWhere('customer_id', $user->customer_id ?? 0)
            ->latest()
            ->first();

        if (!$document) {
            return redirect()->route('my-documents')->with('error', 'No documents found.');
        }

        $data = [];
        $imageFilename = null;
        $folder = '';

        switch ($type) {
            case 'aadhaar':
                $data = [
                    'title' => 'Aadhaar Card',
                    'number' => $document->aadhar_card_number,
                    'status' => $document->aadhar_card_image ? 'Verified' : 'Pending',
                    'updated_at' => $document->updated_at,
                    'created_at' => $document->created_at,
                    'otp_verified' => $document->aadhar_card_otp ? 'Yes' : 'No',
                ];
                $imageFilename = $document->aadhar_card_image;
                $folder = 'private_uploads/aadhar_card';
                break;

            case 'pan':
                $data = [
                    'title' => 'PAN Card',
                    'number' => $document->pan_card_number,
                    'status' => $document->pan_card_image ? 'Verified' : 'Pending',
                    'updated_at' => $document->updated_at,
                    'created_at' => $document->created_at,
                    'otp_verified' => $document->pan_card_otp ? 'Yes' : 'No',
                ];
                $imageFilename = $document->pan_card_image;
                $folder = 'private_uploads/pan_card';
                break;

            default:
                abort(404);
        }

        // Handle Image loading for PDF
        $imageBase64 = null;
        $imageMimeType = null;

        if ($imageFilename) {
            $path = storage_path('app/private/' . $folder . '/' . $imageFilename);
            if (!file_exists($path)) {
                $path = storage_path('app/' . $folder . '/' . $imageFilename);
            }

            if (file_exists($path)) {
                $imageData = file_get_contents($path);
                $imageBase64 = base64_encode($imageData);
                $imageMimeType = mime_content_type($path);
            }
        }

        $pdf = Pdf::loadView('documents.pdf', compact('document', 'user', 'data', 'imageBase64', 'imageMimeType'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream($type . '_document.pdf');
    }
}
