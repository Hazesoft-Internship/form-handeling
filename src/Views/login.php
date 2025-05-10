<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Form</title>

    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: "Arial", sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Form container styling */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 350px;
        }

        /* Label and Input styling */
        label {
            display: block;
            font-size: 13px;
            margin-bottom: 6px;
            color: #333;
        }

        input,
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input:focus,
        button:focus {
            outline: none;
            border-color: #007bff;
        }

        input::placeholder {
            color: #aaa;
        }

        /* Styling for the button */
        button {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Styling for the form header */
        h1 {
            text-align: center;
            margin-bottom: 15px;
            color: #333;
            font-size: 20px;
        }

        /* Styling for the login link */
        .signup-link {
            text-align: center;
            font-size: 14px;
        }

        .signup-link a {
            color: #007bff;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <form action="/login" method="POST">
        <h1>Login</h1>

        <label for="email">Email</label>
        <input
            type="email"
            name="email"
            id="email"
            placeholder="Email"
            required />

        <label for="password">Password</label>
        <input
            type="password"
            name="password"
            id="password"
            placeholder="Password"
            required />

        <button type="submit">Login</button>

        <div class="signup-link">
            <p>Don't have an account? <a href="/signup">Sign up here</a></p>
        </div>
    </form>
</body>

</html>