<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $data['title'] }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #2d3748;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3182ce;
            padding-bottom: 20px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: #3182ce;
            margin: 0;
        }

        .document-title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .meta-table th,
        .meta-table td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .meta-table th {
            width: 150px;
            color: #718096;
            font-size: 12px;
            text-transform: uppercase;
        }

        .image-container {
            text-align: center;
            margin-top: 20px;
            border: 1px solid #e2e8f0;
            padding: 10px;
            background: #f7fafc;
        }

        .doc-image {
            max-width: 100%;
            max-height: 800px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #a0aec0;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            background: #d4edda;
            color: #155724;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    {{-- <div class="header">
        <h1 class="logo-text">{{ config('app.name', 'AI Loan Portal') }}</h1>
        <p>Document Locker Verification Record</p>
    </div>

    <h2 class="document-title">{{ $data['title'] }}</h2>

    <table class="meta-table">
        <tr>
            <th>Document Number</th>
            <td>{{ $data['number'] ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $document->customer_name ?? $user->name }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="status-badge">{{ $data['status'] }}</span>
            </td>
        </tr>
        <tr>
            <th>Verified On</th>
            <td>{{ $data['updated_at']->format('d M, Y h:i A') }}</td>
        </tr>
        <tr>
            <th>OTP Verified</th>
            <td>{{ $data['otp_verified'] }}</td>
        </tr>
    </table> --}}

    <div class="image-container">
        @if ($imageBase64)
            <img src="data:{{ $imageMimeType }};base64,{{ $imageBase64 }}" class="doc-image">
        @else
            <p>No Image Available</p>
        @endif
    </div>

    {{-- <div class="footer">
        <p>This document was securely retrieved from your AI Loan Portal Document Locker.</p>
        <p>Generated on {{ now()->format('d M, Y h:i A') }}</p>
    </div> --}}
</body>

</html>
