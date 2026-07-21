<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Resume</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            font-family: DejaVu Sans, sans-serif;
        }

        .container {
            display: table;
            width: 100%;
            min-height: 100vh;
            table-layout: fixed;
        }

        .sidebar {
            display: table-cell;
            width: 30%;
            background-color: #242a62;
            color: #fff;
            padding: 20px;
            box-sizing: border-box;
            border-right: 4px solid #f26824;
            vertical-align: top;
        }

        .main-content {
            display: table-cell;
            width: 70%;
            padding: 25px;
            box-sizing: border-box;
            vertical-align: top;
        }

        .sidebar img.profile {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #f26824;
            margin: 0 auto;
            display: block;
        }

        .sidebar h3 {
            text-align: center;
            font-size: 20px;
            margin-top: 14px;
        }

        .sidebar .section {
            margin-top: 24px;
        }

        /* .sidebar .section strong {
            font-size: 14px;
            display: block;
            margin-bottom: 6px;
        } */
         .sidebar .section strong {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .sidebar .section div,
        .sidebar .section li {
            font-size: 13px;
            margin-bottom: 6px;
        }

        .skills {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .main-content h2 {
            font-size: 26px;
            margin: 0;
            color: #22304a;
        }

        .main-content .designation {
            color: #6c7a89;
            font-size: 15px;
            margin-bottom: 24px;
        }

        .main-content .section {
            margin-bottom: 24px;
            page-break-inside: avoid;
        }

        .main-content .section-title {
            font-size: 15px;
            font-weight: bold;
            color: #305094;
            margin-bottom: 8px;
        }

        .main-content .section p {
            font-size: 13px;
            color: #555;
            margin: 0;
            line-height: 1.5;
            text-align: justify;
        }

        .footer {
            font-size: 10px;
            margin-top: 40px;
            color: #ccc;
            text-align: center;
        }
        .skills {
            list-style: disc;
            margin-left: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <img src="{{ asset($profile) }}" alt="Profile" class="profile">
            <h3>{{ $name }}</h3>

            {{-- <div class="section">
                <strong>Contact</strong>
                <div>📧 {{ $email }}</div>
                <div>📞 {{ $phone }}</div>
            </div> --}}
            <div class="section">
                <strong>Contact</strong>

                <div>Email : {{ $email ?: '-' }}</div>

                <div>Phone : {{ $phone ?: '-' }}</div>
            </div>

            
            {{-- <div class="section">
                <strong>Personal Information</strong>
                <div>🎂 Date of Birth: {{ $dob? date("d/m/Y", strtotime($dob)) :'-' }}</div>
                <div>💍 Marital Status: {{ $marital_status }}</div>
                <div>🏠 Address: {{ $address }}</div>
                <div>🗣️ Languages Known: {{ $language_known }}</div>
                <div>🚻 Gender: {{ $gender }}</div>
            </div> --}}
            <div class="section">
                <strong>Personal Information</strong>

                <div>Date of Birth : {{ $dob ? date("d/m/Y", strtotime($dob)) : '-' }}</div>

                <div>Marital Status : {{ $marital_status ?: '-' }}</div>

                <div>Address : {{ $address ?: '-' }}</div>

                <div>Languages Known : {{ $language_known ?: '-' }}</div>

                <div>Gender : {{ $gender ?: '-' }}</div>
            </div>


            <div class="section">
                <strong>Skills</strong>
                {{-- <ul class="skills">
                    @foreach ($skills as $skill)
                        <li>✅ {{ $skill }}</li>
                    @endforeach
                </ul> --}}
                <ul class="skills">
                    @foreach ($skills as $skill)
                        <li>{{ $skill }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="footer">© Designed by Zobpot</div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h2>{{ $name }}</h2>
            <div class="designation">{{ $designation }}</div>

            <div class="section">
                <div class="section-title">Summary</div>
                <p>{{ $summary }}</p>
            </div>

            <div class="section">
                <div class="section-title">Experience</div>
                <p>{{ $experience }}</p>
            </div>

            <div class="section">
                <div class="section-title">Education</div>
                <p>{{ $education }}</p>
            </div>
        </div>
    </div>

</body>

</html>
