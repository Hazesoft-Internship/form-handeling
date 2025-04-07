<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form</title>
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
            /* Reduced max-width */
        }

        /* Label and Input styling */
        label {
            display: block;
            font-size: 13px;
            /* Reduced font size */
            margin-bottom: 6px;
            color: #333;
        }

        input,
        button {
            width: 100%;
            padding: 10px;
            /* Reduced padding */
            margin-bottom: 12px;
            /* Reduced margin */
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
            /* Reduced font size */
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
            /* Reduced margin */
            color: #333;
            font-size: 20px;
            /* Reduced font size */
        }
    </style>
</head>

<body>
    <form action="/signup" method="POST">
        <h1>Register</h1>

        <label for="first-name">First Name</label>
        <input
            type="text"
            name="first_name"
            id="first-name"
            placeholder="First Name" />

        <label for="middle-name">Middle Name</label>
        <input
            type="text"
            name="middle_name"
            id="middle-name"
            placeholder="Middle Name" />

        <label for="last-name">Last Name</label>
        <input
            type="text"
            name="last_name"
            id="last-name"
            placeholder="Last Name" />

        <label for="address">Address</label>
        <input type="text" name="address" id="address" placeholder="Address" />

        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Email" />

        <label for="password">Password</label>
        <input
            type="password"
            name="password"
            id="password"
            placeholder="Password" />
        <label for="confirm-password">Confirm Password</label>
        <input
            type="password"
            name="confirm_password"
            id="confirm-password"
            placeholder="Confirm Password" />

        <button type="submit">Submit</button>
    </form>
</body>

</html>