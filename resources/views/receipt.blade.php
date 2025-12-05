<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Aadhaar Verification Receipt</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@100..900&display=swap"
        rel="stylesheet">
    <style>
        /* THESE RULES MUST STAY IN HEAD TO WORK IN DOMPDF */

        /* 1. Load Local Font */
        @font-face {
            font-family: 'Noto Sans Devanagari';
            font-style: normal;
            font-weight: normal;
            /* src: url('{{ public_path('fonts/NotoSansDevanagari-Regular.ttf') }}') format('truetype'); */
        }

        /* 2. Page Margins */
        @page {
            size: A4;
            margin: 0;
        }
    </style>
</head>

<body
    style="font-family: 'Noto Sans Devanagari', sans-serif; margin: 0; padding: 0; background-color: #fff; color: #222;">

    <div style="width: 80%; padding: 15mm; box-sizing: border-box; margin: 0 auto;">

        <div style="width: 100%; border-bottom: 3px solid #db8e31; padding-bottom: 15px; margin-bottom: 20px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td width="15%" align="left" style="vertical-align: middle;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/Emblem_of_India.svg/100px-Emblem_of_India.svg.png"
                            width="60" alt="Emblem" style="display: block;">
                    </td>

                    <td width="70%" align="center" style="vertical-align: middle; text-align: center;">
                        <span
                            style="font-family: 'Noto Sans Devanagari', sans-serif; font-weight: normal; font-size: 14pt; display: block;">
                            भारत सरकार
                        </span>

                        <h1
                            style="font-size: 16pt; font-weight: bold; margin: 0; text-transform: uppercase; line-height: 1.2;">
                            Government of India
                        </h1>

                        <span
                            style="font-family: 'Noto Sans Devanagari, sans-serif; font-weight: normal; font-size: 10pt; color: #555; display: block; margin-top: 5px;">
                            भारतीय विशिष्ट पहचान प्राधिकरण
                        </span>

                        <h2 style="font-size: 11pt; font-weight: normal; margin: 2px 0 5px 0; color: #555;">
                            Unique Identification Authority of India
                        </h2>

                        <div style="font-size: 10pt; font-weight: bold; margin-top: 5px; text-decoration: underline;">
                            Aadhaar Verification Receipt
                        </div>
                    </td>

                    <td width="15%" align="right" style="vertical-align: middle;">
                        <img src="https://upload.wikimedia.org/wikipedia/en/thumb/c/cf/Aadhaar_Logo.svg/100px-Aadhaar_Logo.svg.png"
                            width="70" alt="Aadhaar" style="display: block;">
                    </td>
                </tr>
            </table>
        </div>

        <div
            style="background-color: #e8f5e9; border: 1px solid #2e7d32; color: #1b5e20; padding: 10px; text-align: center; font-size: 12pt; font-weight: bold; border-radius: 4px; margin-bottom: 25px;">
            <span>&#10003;</span> Authentication Successful /
            <span style="font-family: 'Noto Sans Devanagari, sans-serif; font-weight: normal;">प्रमाणीकरण सफल</span>
        </div>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td width="60%" style="vertical-align: top; padding: 5px;">

                    <div style="margin-bottom: 15px;">
                        <span
                            style="font-size: 8pt; color: #666; text-transform: uppercase; margin-bottom: 3px; display: block;">
                            Resident Name / <span
                                style="font-family: 'Noto Sans Devanagari, sans-serif; font-weight: normal;">निवासी का
                                नाम</span>
                        </span>
                        <span style="font-size: 11pt; font-weight: bold; color: #000; display: block;">
                            {{ $name ?? 'Amit Kumar' }}
                        </span>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <span
                            style="font-size: 8pt; color: #666; text-transform: uppercase; margin-bottom: 3px; display: block;">
                            Aadhaar Number / <span
                                style="font-family: 'Noto Sans Devanagari, sans-serif; font-weight: normal;">आधार
                                संख्या</span>
                        </span>
                        <span
                            style="font-size: 11pt; font-weight: bold; color: #000; display: block; font-family: 'Courier New', monospace; letter-spacing: 2px;">
                            {{ $aadhaar_number_masked ?? '4513 XXXX 0803' }}
                        </span>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <span
                            style="font-size: 8pt; color: #666; text-transform: uppercase; margin-bottom: 3px; display: block;">
                            Authentication Method / <span
                                style="font-family: 'Noto Sans Devanagari, sans-serif; font-weight: normal;">प्रमाणीकरण
                                विधि</span>
                        </span>
                        <span style="font-size: 11pt; font-weight: bold; color: #000; display: block;">
                            OTP (One Time Password)
                            <span style="color:green; font-size:10px; vertical-align: middle;">[ VERIFIED ]</span>
                        </span>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <span
                            style="font-size: 8pt; color: #666; text-transform: uppercase; margin-bottom: 3px; display: block;">
                            Response Code / <span
                                style="font-family: 'Noto Sans Devanagari, sans-serif; font-weight: normal;">प्रतिक्रिया
                                कोड</span>
                        </span>
                        <div
                            style="background:#f5f5f5; padding:5px; font-family:monospace; font-size:9pt; width: 90%; word-wrap: break-word; border-radius: 3px;">
                            {{ substr($response_code ?? '96E164B006C32B98DB0A9A2ACE22FAAD', 0, 30) }}...
                        </div>
                    </div>
                </td>

                <td width="40%" align="center" style="vertical-align: top; padding: 5px;">
                    <span
                        style="font-size: 8pt; color: #666; text-transform: uppercase; margin-bottom: 5px; display: block; text-align:center;">
                        ID Card Image
                    </span>

                    <div style="width: 200px; border: 1px solid #ddd; padding: 5px; background: #fafafa;">
                        @if (!empty($aadhar_card_image))
                            <img src="data:{{ $aadhar_card_image_mime }};base64,{{ $aadhar_card_image }}"
                                alt="Aadhaar Card" style="width: 100%; height: auto; display: block;">
                        @else
                            <div style="padding:40px 0; color:#ccc; text-align: center;">No Image</div>
                        @endif
                    </div>

                    <div style="margin-top: 10px;">
                        <span
                            style="color: green; font-weight: bold; border: 1px solid green; padding: 3px 8px; border-radius: 4px; font-size: 9pt;">
                            MATCH FOUND
                        </span>
                    </div>
                </td>
            </tr>
        </table>

        <table
            style="width: 100%; margin-top: 30px; background-color: #f1f8ff; border-left: 4px solid #005691; padding: 10px; font-size: 9pt; border-collapse: separate; border-spacing: 5px;">
            <tr>
                <td align="left">
                    <strong style="display:block; color:#005691;">Transaction ID</strong>
                    {{ $transaction_id ?? '44138419' }}
                </td>
                <td align="center">
                    <strong style="display:block; color:#005691;">
                        Date / <span
                            style="font-family: 'Noto Sans Devanagari, sans-serif; font-weight: normal;">दिनांक</span>
                    </strong>
                    {{ $verification_date ?? date('d/m/Y') }}
                </td>
                <td align="right">
                    <strong style="display:block; color:#005691;">
                        Time / <span
                            style="font-family: 'Noto Sans Devanagari, sans-serif; font-weight: normal;">समय</span>
                    </strong>
                    {{ $verification_time ?? date('H:i:s') }}
                </td>
            </tr>
        </table>

        <div
            style="margin-top: 50px; text-align: center; font-size: 8pt; color: #888; border-top: 1px solid #ddd; padding-top: 10px;">
            This is a computer-generated receipt. /
            <span style="font-family: 'Noto Sans Devanagari, sans-serif; font-weight: normal;">यह एक कंप्यूटर जनित रसीद
                है।</span>
            <br>
            © {{ date('Y') }} Unique Identification Authority of India
        </div>

    </div>
</body>

</html>
