<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test OCR Integration</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }
        input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 2px dashed #667eea;
            border-radius: 8px;
            background: #f8f9ff;
            cursor: pointer;
        }
        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        button:hover {
            transform: translateY(-2px);
        }
        .result {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9ff;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .result h2 {
            color: #667eea;
            margin-bottom: 15px;
        }
        .result-item {
            padding: 10px;
            margin: 8px 0;
            background: white;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
        }
        .result-label {
            font-weight: 600;
            color: #333;
        }
        .result-value {
            color: #667eea;
        }
        .success {
            color: #28a745;
            font-weight: 600;
        }
        .error {
            color: #dc3545;
            font-weight: 600;
        }
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #17a2b8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Test OCR Integration</h1>
        <p class="subtitle">Upload Aadhaar card image to test OCR extraction</p>

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="info">
            <strong>📝 Instructions:</strong><br>
            1. Upload a clear Aadhaar card image (JPG/PNG/PDF)<br>
            2. System will extract: Name, Phone, Email, DOB, Gender, Address<br>
            3. Results will be displayed below
        </div>

        <form action="{{ route('test.ocr.post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="aadhaar_image">📄 Upload Aadhaar Card Image:</label>
                <input type="file" name="aadhaar_image" id="aadhaar_image" accept="image/jpeg,image/png,application/pdf" required>
            </div>
            <button type="submit">🚀 Extract Data from Aadhaar Card</button>
        </form>

        @if(isset($result) && $result)
            <div class="result">
                <h2>✅ Extraction Results:</h2>
                
                <div class="result-item">
                    <span class="result-label">👤 Name:</span>
                    <span class="result-value {{ $result['name'] ? 'success' : 'error' }}">
                        {{ $result['name'] ?? '❌ Not found' }}
                    </span>
                </div>

                <div class="result-item">
                    <span class="result-label">📱 Phone:</span>
                    <span class="result-value {{ $result['phone'] ? 'success' : 'error' }}">
                        {{ $result['phone'] ?? '❌ Not found' }}
                    </span>
                </div>

                <div class="result-item">
                    <span class="result-label">📧 Email:</span>
                    <span class="result-value {{ $result['email'] ? 'success' : 'error' }}">
                        {{ $result['email'] ?? '❌ Not found (will be generated)' }}
                    </span>
                </div>

                <div class="result-item">
                    <span class="result-label">🆔 Aadhaar Number:</span>
                    <span class="result-value {{ $result['aadhaar_number'] ? 'success' : 'error' }}">
                        {{ $result['aadhaar_number'] ?? '❌ Not found' }}
                    </span>
                </div>

                <div class="result-item">
                    <span class="result-label">🎂 Date of Birth:</span>
                    <span class="result-value {{ $result['date_of_birth'] ? 'success' : 'error' }}">
                        {{ $result['date_of_birth'] ?? '❌ Not found' }}
                    </span>
                </div>

                <div class="result-item">
                    <span class="result-label">⚧️ Gender:</span>
                    <span class="result-value {{ $result['gender'] ? 'success' : 'error' }}">
                        {{ $result['gender'] ?? '❌ Not found' }}
                    </span>
                </div>

                <div class="result-item">
                    <span class="result-label">📍 Address:</span>
                    <span class="result-value {{ $result['address'] ? 'success' : 'error' }}">
                        {{ $result['address'] ? substr($result['address'], 0, 100) . '...' : '❌ Not found' }}
                    </span>
                </div>

                <div style="margin-top: 20px; padding: 15px; background: #e7f3ff; border-radius: 8px;">
                    <strong>✅ OCR Integration is working!</strong><br>
                    The system successfully extracted data from your Aadhaar card.
                </div>
            </div>
        @elseif(isset($result) && !$result)
            <div class="result">
                <h2 class="error">❌ Extraction Failed</h2>
                <p>Could not extract data from the image. Please check:</p>
                <ul style="margin-left: 20px; margin-top: 10px;">
                    <li>Image is clear and readable</li>
                    <li>API key is correct</li>
                    <li>Image format is supported (JPG/PNG/PDF)</li>
                    <li>Check logs: storage/logs/laravel.log</li>
                </ul>
            </div>
        @endif
    </div>
</body>
</html>

