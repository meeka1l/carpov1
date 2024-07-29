<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Carpo</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
nav {
    background-color: white;
    overflow: hidden;
}

nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
     /* To make the links inline */
}

nav ul a {
    display: inline-block;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    background-color: white;
    transition: background-color 0.1s, color 0.1s, font-weight 0.1s;
    flex: 1; /* To evenly distribute the links */
}

nav ul a:hover {
    
    color: black;
}

nav ul a.active {
    font-weight: bold;
}

nav ul a:not(.active) {
    opacity: 0.6;
}


    </style>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <h1>CARPO</h1>
            <h2>Welcome to Carpo</h2>
            <nav>
    <ul>
        <a href="#" id="show-navigator" class="active">Navigator Mode</a>
        <a href="#" id="show-commuter">Commuter Mode</a>
    </ul>
</nav>
        </header>

        <!-- Navigator Page Section -->
        <section class="navigator-page" id="navigator-page" style="display: none;">
            
            <p>Content for the navigator page goes here.</p>
        </section>

        <!-- Commuter Page Section -->
        <section class="commuter-page" id="commuter-page">
            
            <p>Content for the commuter page goes here.</p>
        </section>

        

        <!-- Logout Form -->
        <form action="{{ route('logout') }}" method="POST" style="text-align: center; margin-top: 20px;">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const navigatorLink = document.getElementById('show-navigator');
    const commuterLink = document.getElementById('show-commuter');
    const navigatorPage = document.getElementById('navigator-page');
    const commuterPage = document.getElementById('commuter-page');

    // Default view
    navigatorPage.style.display = 'none';
    commuterPage.style.display = 'block';

    navigatorLink.addEventListener('click', function(event) {
        event.preventDefault();
        navigatorPage.style.display = 'block';
        commuterPage.style.display = 'none';
    });

    commuterLink.addEventListener('click', function(event) {
        event.preventDefault();
        commuterPage.style.display = 'block';
        navigatorPage.style.display = 'none';
    });
});
document.querySelectorAll('nav ul a').forEach(item => {
        item.addEventListener('click', event => {
            document.querySelectorAll('nav ul a').forEach(link => {
                link.classList.remove('active');
            });
            event.target.classList.add('active');
        });
    });
    </script>
</body>
</html>
