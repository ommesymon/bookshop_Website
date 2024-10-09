<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact - Zia Book Shop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .topnav {
            overflow: hidden;
            background-color: #333;
        }
        .topnav a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }
        .content {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .content h2 {
            color: #4CAF50;
        }
        .form-container {
            margin-top: 20px;
        }
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <div class="header">
        <h1>Contact Us</h1>
    </div>

    <!-- Navigation Bar -->
    <div class="topnav">
        <a href="index.php">Home</a>
       
        
        <a href="review.php">Reviews</a>
        
        <a href="?sign=out" style="float:right">Logout</a>
    </div>

    <!-- Main Content Section -->
    <div class="content">
        <h2>We’d Love to Hear From You!</h2>
        <p>Email: <a href="mailto:saimunbintezia70@gmail.com">saimunbintezia70@gmail.com</a></p>
        <p>Phone: 01943331625</p>

        <!-- Contact Form -->
        <div class="form-container">
            <h3>Send us a Message:</h3>
            <form action="contact.php" method="post">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Your Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <input type="submit" name="submit" value="Send Message">
            </form>
        </div>
    </div>

    

</body>
</html>

