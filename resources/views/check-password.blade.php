@extends('layouts.app')

@section('page_title', 'Your Best Lawyer | Password')

@section('content')
    <style>
        /* Reset margins and paddings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Centered content */
        body, html {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #000; /* Black background */
            font-family: Arial, sans-serif;
        }

        /* Form container */
        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #333;
            padding: 2rem;
            /* border-radius: 8px; */
            width: 90%;
            max-width: 400px;
        }

        /* Password input */
        input[type="password"] {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 1rem;
            border: none;
            width: 100%;
            max-width: 300px;
            background-color: #555;
            color: #fff;
        }

        /* Submit button */
        button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            width: 100%;
            max-width: 300px;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Responsive typography */
        h1 {
            color: #fff;
            font-size: 24px;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        header {
            display: none;
        }
        footer {
            display: none;
        }
    </style>

<div class="form-container">
    <h1>Enter Password</h1>
    <form action="{{route('check_password_validate')}}" method="POST">@csrf
        <!-- Password Field -->
        <input type="password" name="password" placeholder="Enter Password" required>
        @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror

        <!-- Submit Button -->
        <button type="submit" class="btn-primary">Submit</button>
    </form>
</div>

@endsection
