<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 30px;
    background: white;
}

.logo {
    display: flex;
    align-items: center;
    font-weight: bold;
    font-size: 1.2em;
}

.logo img {
    width: 40px;
    height: 40px;
    margin-right: 10px;
}

.nav {
    display: flex;
    gap: 20px;
}

.nav a {
    text-decoration: none;
    color: black;
    font-weight: bold;
}

.icons {
    display: flex;
    align-items: center;
    gap: 15px;
}

.icons img {
    width: 30px;
    height: 30px;
}

.logout {
    padding: 8px 15px;
    border: none;
    border-radius: 20px;
    background: linear-gradient(45deg, #fda085, #f6d365);
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: opacity 0.3s;
}

.logout:hover {
    opacity: 0.8;
}
</style>

<header class="header">
        <div class="logo">
            <img src="../img/logo.png" alt="Logo IUTables’O">
            <span>IUTables’O</span>
        </div>
        <nav class="nav">
            <a href="#">Favoris</a>
            <a href="#">Mes Critiques</a>
            <a href="#">Contact</a>
        </nav>
        <div class="icons">
            <img src="../img/home-icon.png" alt="Accueil"><a href="#"></a>
            <img src="../img/user-icon.png" alt="Profil"><a href="#"></a>
            <button class="logout"><a href="../utils/connection/logout.php"></a>Se déconnecter</button>
        </div>
</header>