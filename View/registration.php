
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <Script src ="../Controller/JS/CheckEmail.js"> </Script>
    <title>Registration</title>

        <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
        }

        .container {
            background: #1a3a5c;
            color: #e6f1fb;
            text-align: center;
            padding: 1.2rem 2rem;
        }

        .container h1 {
            font-size: 22px;
            font-weight: 500;
        }

        .form-container {
            max-width: 480px;
            margin: 2rem auto;
            background: #ffffff;
            border: 1px solid #dde3eb;
            border-radius: 12px;
            padding: 2rem 2.5rem;
        }

        .form-container h1 {
            font-size: 20px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 0.25rem;
        }

        .required-note {
            font-size: 13px;
            color: #c0392b;
            margin-bottom: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tr td {
            padding: 6px 4px;
            vertical-align: middle;
        }

        label {
            font-size: 13px;
            font-weight: 500;
            color: #555;
            white-space: nowrap;
            padding-right: 12px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        select {
            width: 100%;
            padding: 9px 12px;
            font-size: 14px;
            font-family: inherit;
            background: #f7f9fc;
            color: #1a1a1a;
            border: 1px solid #c8d0da;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="date"]:focus,
        select:focus {
            border-color: #185fa5;
            box-shadow: 0 0 0 3px rgba(24, 95, 165, 0.12);
            background: #fff;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #1a3a5c;
            color: #e6f1fb;
            font-size: 15px;
            font-weight: 500;
            font-family: inherit;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s;
        }

        input[type="submit"]:hover {
            background: #133055;
        }

        input[type="submit"]:active {
            transform: scale(0.98);
        }

        #userresponse {
            font-size: 12px;
            color: #c0392b;
        }

        .divider {
            border: none;
            border-top: 1px solid #eaecf0;
            margin: 1.25rem 0;
        }

        a {
            color: #185fa5;
            font-size: 13px;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>



</head>
<body>
        <div class="container">
            <h1>Weclome to Bashundhara Library</h1>
        </div>

        <div class="form-container">
        <form method = "post" action="../Controller/RegistrationValid.php">
            <h1>Registration</h1>

            <table>
                <tr>
                    <td><p style = 'color: red '>*Required Field </p></td><br>
                </tr>
                <tr>
                    <td> <label for ="name">Name: </label></td>
                    <td> <input type ="text" id = "name" name = "name"></td>
                    <td> <p style = 'color: red'>*</p> </td>
                </tr>

                <tr>
                    <td> <label for ="email">Email: </label></td>
                    <td> <input type = "email" id="email" name ="email" onkeyup="CheckEmail()"></td>
                </tr>


                
                <tr>
                    <td></td>
                    <td id="userresponse" style="color: red;"></td>
                    <td><p id="userresponse" style="color: red;"></p></td>
             </tr>

                <tr>
                    <td> <label for ="phone">Phone:</label></td>
                    <td> <input type = "text" id="phone" name ="phone"></td>
                </tr>

                <tr>
                    <td> <label for ="password">Password</label></td>
                    <td> <input type = "password" id="password" name ="password"></td>
                </tr>

                <tr>
                    <td> <label for="role">Role:</label></td>
                    <td>
                        <select id="role" name="role">
                            <option value="member">member</option>
                            <option value="librarian">librarian</option>
                            <option value="admin">admin</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="date">Creation Date:</label></td>
                    <td><input type="date" id="date" name="date"></td>
                </tr>


                <tr>
                    <td colspan="2"><a href="login.php">Already Registered? Login here</a></td>
                </tr>
                
                <tr>
                    <td></td>
                    <td><input type = "submit" id = "submit" name = "submit" value="Submit"> </td>
                </tr>

            </table>
        </form>
        </div>



    </div>

</body>
</html>