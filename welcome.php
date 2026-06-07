<?php
// Welcome page for Startup Collaboration Portal
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Startup Collaboration Portal</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap');
        
        :root {
            --bg-primary: #0a0e27;
            --gradient-primary: linear-gradient(135deg, #6c63ff, #00d2ff);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Abstract Background Elements */
        .bg-blob-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(108, 99, 255, 0.15) 0%, rgba(10, 14, 39, 0) 70%);
            border-radius: 50%;
            z-index: 1;
        }

        .bg-blob-2 {
            position: absolute;
            bottom: -20%;
            right: -10%;
            width: 60vw;
            height: 60vw;
            background: radial-gradient(circle, rgba(0, 210, 255, 0.1) 0%, rgba(10, 14, 39, 0) 70%);
            border-radius: 50%;
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 10;
            display: flex;
            max-width: 1200px;
            width: 90%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            animation: fadeIn 1s ease-out;
        }

        .image-section {
            flex: 1;
            position: relative;
            min-height: 600px;
        }

        .image-section img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: grayscale(100%) contrast(1.2) brightness(0.8);
            transition: filter 0.5s ease;
        }
        
        .image-section::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to right, rgba(10,14,39,0.2), var(--bg-primary));
        }

        .image-section:hover img {
            filter: grayscale(30%) contrast(1.2) brightness(0.9);
        }

        .content-section {
            flex: 1;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .badge {
            display: inline-block;
            padding: 6px 16px;
            background: rgba(108, 99, 255, 0.2);
            color: #8c85ff;
            border-radius: 30px;
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 24px;
            text-transform: uppercase;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 24px;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .quote-box {
            position: relative;
            margin: 2rem 0;
            padding-left: 1.5rem;
            border-left: 4px solid #6c63ff;
        }

        .quote {
            font-size: 1.5rem;
            font-weight: 300;
            line-height: 1.6;
            color: var(--text-primary);
            font-style: italic;
        }

        .author {
            margin-top: 1rem;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .author span {
            color: #00d2ff;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: var(--gradient-primary);
            color: white;
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            width: fit-content;
            margin-top: 2rem;
            box-shadow: 0 10px 20px rgba(108, 99, 255, 0.3);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(108, 99, 255, 0.4);
        }

        .btn i {
            transition: transform 0.3s ease;
        }

        .btn:hover i {
            transform: translateX(5px);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 992px) {
            .container {
                flex-direction: column;
            }
            .image-section {
                min-height: 300px;
            }
            .image-section::after {
                background: linear-gradient(to bottom, rgba(10,14,39,0), var(--bg-primary));
            }
            h1 { font-size: 2.5rem; }
            .quote { font-size: 1.2rem; }
            .content-section { padding: 3rem 2rem; }
        }
    </style>
</head>
<body>
    <div class="bg-blob-1"></div>
    <div class="bg-blob-2"></div>

    <div class="container">
        <div class="image-section">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/dc/Steve_Jobs_Headshot_2010-CROP_%28cropped_2%29.jpg/800px-Steve_Jobs_Headshot_2010-CROP_%28cropped_2%29.jpg" alt="Steve Jobs">
        </div>
        <div class="content-section">
            <div>
                <div class="badge">Innovation Awaits</div>
                <h1>WELCOME TO<br>STARTUP WORLD</h1>
                
                <div class="quote-box">
                    <p class="quote">"The ones who are crazy enough to think that they can change the world, are the ones who do."</p>
                    <p class="author">― <span>Steve Jobs</span></p>
                </div>

                <a href="index.php" class="btn">
                    Enter Portal <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
