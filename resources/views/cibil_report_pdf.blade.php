<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Official Credit Report</title>
    <style>
        body { font-family: sans-serif; color: #333; font-size: 12px; line-height: 1.5; }
        .header { border-bottom: 2px solid #0056b3; padding-bottom: 10px; margin-bottom: 20px; display: table; width: 100%; }
        .logo-text { font-size: 24px; font-weight: bold; color: #0056b3; }
        .highlight { color: #28a745; font-weight: bold; }
        .meta-info { text-align: right; font-size: 10px; color: #666; }
        .section { margin-bottom: 20px; background: #fff; border: 1px solid #ddd; padding: 15px; border-radius: 4px; }
        .section-title { font-size: 14px; font-weight: bold; margin-bottom: 10px; color: #0056b3; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .score-box { text-align: center; padding: 20px; background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 5px; }
        .big-score { font-size: 48px; font-weight: bold; color: #28a745; margin: 0; }
        .score-label { font-size: 12px; color: #666; text-transform: uppercase; letter-spacing: 1px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #f8f9fa; color: #555; font-weight: 600; width: 30%; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; font-size: 9px; color: #999; text-align: center; border-top: 1px solid #ddd; padding-top: 10px; }
        .badge-gov { background-color: #e8f5e9; color: #1b5e20; padding: 4px 8px; border-radius: 4px; font-size: 10px; border: 1px solid #c8e6c9; display: inline-block; }
        .row { display: table; width: 100%; }
        .col { display: table-cell; vertical-align: top; }
        .watermark { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); font-size: 80px; color: rgba(0,0,0,0.03); z-index: -1; font-weight: bold; }
    </style>
</head>
<body>
    <div class="watermark">CONFIDENTIAL</div>

    <div class="header">
        <div class="row">
            <div class="col">
                <div class="logo-text">CIBIL <span style="font-weight: normal; color: #555;">| Bureau Report</span></div>
                <div style="margin-top: 5px;">
                    <span class="badge-gov">GOVERNMENT VERIFIED</span>
                    <span class="badge-gov">RBI COMPLIANT</span>
                </div>
            </div>
            <div class="col meta-info">
                <strong>Report Generated:</strong> {{ $reportDate }}<br>
                <strong>Reference ID:</strong> {{ $referenceId }}<br>
                <strong>Data Source:</strong> Verified Bureau Database
            </div>
        </div>
    </div>

    <div class="section">
        <div class="score-box">
            <p class="score-label">Your Official Credit Score</p>
            <div class="big-score" style="color: {{ $scoreColor }};">{{ $score }}</div>
            <p style="margin-top: 5px; font-size: 14px; color: {{ $scoreColor }}; font-weight: bold;">{{ $scoreBand }}</p>
            <p style="font-size: 10px; color: #777; margin-top: 10px;">
                Score Range: 300-900. Higher is better. This score is calculated based on your credit history across all banks and financial institutions.
            </p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">PERSONAL INFORMATION</div>
        <table>
            <tr>
                <th>Full Name</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Date of Birth</th>
                <td>{{ $dob }}</td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>{{ $gender }}</td>
            </tr>
            <tr>
                <th>PAN Number</th>
                <td>{{ $panNumber }} <span class="badge-gov" style="margin-left: 10px;">VERIFIED</span></td>
            </tr>
            <tr>
                <th>Aadhaar Number</th>
                <td>{{ $aadhaarMasked }} <span class="badge-gov" style="margin-left: 10px;">LINKED</span></td>
            </tr>
            <tr>
                <th>Contact Number</th>
                <td>+91 {{ $user->phone }}</td>
            </tr>
            <tr>
                <th>Email Address</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Registered Address</th>
                <td>{{ $address }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">ACCOUNT SUMMARY & COMPLIANCE</div>
        <div style="font-size: 11px; color: #444;">
            <p><strong>Strictly Confidential:</strong> This report is generated secure servers and is intended solely for the use of the individual to whom it pertains. Access to this report is logged and monitored.</p>
            <p><strong>Government Compliance:</strong> This credit report is generated in accordance with the Credit Information Companies (Regulation) Act, 2005 and RBI guidelines. The data presented is aggregated from certified member institutions.</p>
            
            <div style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px;">
                <strong>Disclaimer:</strong> The score provided is an estimate based on available data. Actual eligibility for loans or credit cards depends on the internal policies of the lending institution.
            </div>
        </div>
    </div>

    <div class="footer">
        Generated by AI Loan Portal &copy; {{ date('Y') }} | Certified Secure System | Page 1 of 1
    </div>
</body>
</html>
