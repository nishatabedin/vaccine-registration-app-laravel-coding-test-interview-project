<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* General form styling */
        form {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
        }

        /* Label styling */
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        /* Input field styling */
        input[type="text"],
        input[type="email"], /* Added email field styling */
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Styling for the select dropdown */
        select {
            appearance: none;
            background-color: #fff;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="none" stroke="%23333" stroke-width=".7" d="M2 0L0 2h4z"/></svg>');
            background-repeat: no-repeat;
            background-position-x: 100%;
            background-position-y: 12px;
            padding-right: 30px;
        }

        /* Error message styling */
        .error {
            color: red;
            font-size: 0.875rem;
            margin-top: -10px;
            margin-bottom: 15px;
        }

        /* Success message styling */
        .success {
            color: green;
            font-size: 1rem;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Button styling */
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<!-- Display the success message if it exists -->
@if (session('success'))
    <div class="success">
        {{ session('success') }}
    </div>
@endif

<form action="/register" method="POST">
    @csrf
    <label for="nid">NID</label>
    <input type="text" name="nid" value="{{ old('nid') }}" required>
    @error('nid')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="name">Name</label>
    <input type="text" name="name" value="{{ old('name') }}" required>
    @error('name')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="email">Email</label>
    <input type="email" name="email" value="{{ old('email') }}" required>
    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror

    <label for="vaccine_center_id">Select Vaccine Center</label>
    <select name="vaccine_center_id">
        <option value="">Choose a center</option>
        <option value="1" {{ old('vaccine_center_id') == 1 ? 'selected' : '' }}>Center 1</option>
      
    </select>
    @error('vaccine_center_id')
        <div class="error">{{ $message }}</div>
    @enderror

    <button type="submit">Register</button>
</form>
</body>
</html>
