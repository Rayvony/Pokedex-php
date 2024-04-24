<div class="header">
    <a href="/pokedex/admin/dashboard.php">
        <img src='/pokedex/assets/Firma.svg' alt='logo' class="firma" />
    </a>
    <form class="search" action="search.php" method="get">
        <input class="searchTerm" type="text" name="search" placeholder="Search Pokémon by name">
        <button type="submit">Search</button>
    </form>

    <?php
    if(isset($_SESSION['admin_id'])) {
        echo '
        <form action="/pokedex/logout.php" method="post">
            <button type="submit" name="logout">Logout</button>
        </form>';
    } else {
        echo '
        <a href="login.php">
            <button>
                Log in
            </button>
        </a>';
    }
    ?>
</div>