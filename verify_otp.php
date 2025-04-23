<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KilimoKe OTP Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white dark:bg-black text-zinc-800 dark:text-white">
    <nav class="bg-green-500 dark:bg-zinc-900 py-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="font-bold text-lg">KilimoKe</a>
        </div>
    </nav>
        
    <div class="min-h-screen flex items-center justify-center bg-zinc-100 dark:bg-zinc-900">
        <div class="bg-white dark:bg-zinc-800 p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-zinc-900 dark:text-white">Verify OTP</h2>
            <form action="verify_otp_process.php" method="POST">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2" for="otp">Enter OTP</label>
                    <input class="form-input mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 text-black dark:text-white bg-white dark:bg-black"
                           type="text"
                           id="otp"
                           name="otp"
                           placeholder="Enter the OTP sent to your email"
                           required
                    />
                </div>
                <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                        type="submit"
                >
                    Verify
                </button>
            </form>
        </div>
    </div>
    
    <footer class="bg-zinc-800 text-white py-8">
        <div class="container mx-auto px-4 flex flex-wrap justify-between">
            <div class="w-full md:w-1/4 mb-8 md:mb-0">
                <h2 class="text-xl font-bold mb-4">About Us</h2>
                <img src="Images/16cb1ad44488d21a13f74756c54d655d.jpg" alt="KilimoKe Logo" class="mb-1" />
                <p class="font-semibold">KilimoKe</p>
                <p>P.O. Box 14133 - 00800 Nairobi, Kenya</p>
                <div class="flex space-x-4 mt-4">
                    <a href="https://web.facebook.com/?_rdc=1&_rdr" aria-label="Facebook"
                       ><img src="Images/660bcb3e9408cfa1747d2d6e4c8c4526.png" alt="Facebook"
                    /></a>
                    <a href="https://x.com/?lang=en" aria-label="Twitter"><img src="Images/F1x5VdQX0AA9Sgt.jpeg" alt="Twitter" /></a>
                    <a href="https://www.instagram.com/" aria-label="Instagram"
                       ><img src="Images/Instagram_logo_2016.svg.png" alt="Instagram"
                    /></a>
                    <a href="https://ke.linkedin.com/" aria-label="LinkedIn"
                       ><img src="Images/linkedin-400850_640-1.webp" alt="LinkedIn"
                    /></a>
                </div>
            </div>
        </div>
        <div class="bg-zinc-900 py-4 mt-8">
            <div class="container mx-auto px-4 flex flex-wrap justify-between items-center">
                <p class="text-sm">&copy; 2024 KilimoKe. All Rights Reserved.</p>
                <div class="flex space-x-4 text-sm">
                    <a href="Home.html" class="hover:underline">Home</a>
                    <a href="ViewCart.html" class="hover:underline">ViewCart</a>
                    <a href="Login.html" class="hover:underline">Login</a>
                    <a href="ContactUs.html" class="hover:underline">Contact Us</a>
                    <a href="AboutUs.html" class="hover:underline">About Us</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
