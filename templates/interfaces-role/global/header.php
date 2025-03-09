
<style>
header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
  background-color: #fff;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

nav a {
  margin: 0 1rem;
  text-decoration: none;
  color: #000;
  font-weight: 500;
}

.btn-connect {
  background: linear-gradient(to right, #ffcc33, #ff9966);
  border: none;
  border-radius: 50px;
  padding: 10px 20px;
  font-size: 16px;
  color: white;
  cursor: pointer;
  font-weight : bold;
}


body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
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
.logo a {
    text-decoration: none;
    color: black;
    font-weight: bold;
}
</style>
<header>
    <div class="logo">
            <img src="../img/logo.png" alt="Logo IUTables’O">
            <span id="home"><a href="index.php"">IUTables’O</a></span>
      </div>
    <nav>
      <a href="decouverte.php">Découvrir</a>
      <a href="#">Avis</a>
      <a href="#">Contact</a>
      <a href="connexion.php"><button class="btn-connect">Se connecter</button></a>
    </nav>
</header>
