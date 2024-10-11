<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Vaccination Status</title>
    <style>
        /* Basic form styling */
        form {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .error {
            color: red;
            font-size: 0.875rem;
        }

        .success {
            color: green;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .info {
            color: #6c757d;
            margin-top: 20px;
        }

        .register-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .register-button:hover {
            background-color: #0056b3;
        }

        /* Additional styling for status section */
        .status-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    </style>
</head>
<body>

@if (session('success'))
    <div class="success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('search.status') }}" method="GET">
    <h2>Search Vaccination Status</h2>
    
    <label for="nid">Enter NID</label>
    <input type="text" name="nid" value="{{ old('nid') }}" required>

    @error('nid')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit">Search</button>
</form>

{{-- Status section to display results --}}
@if (isset($status) || isset($schedule) || isset($registerLink))
    <div class="status-section">
        {{-- Display vaccination status if available --}}
        @if (isset($status))
            <h2>Vaccination Status</h2>
            <p>Status: {{ $status }}</p>
        @endif

        {{-- Display scheduled date if available --}}
        @if (isset($schedule))
            <p>Scheduled Date: {{ $schedule }}</p>
        @endif

        {{-- Display register link if available --}}
        @if (isset($registerLink))
            <div class="info">
                <p>You are not registered for vaccination. Please click the button below to register:</p>
                <a href="{{ $registerLink }}" class="register-button">Register Now</a>
            </div>
        @endif
    </div>
@endif

</body>
</html>
