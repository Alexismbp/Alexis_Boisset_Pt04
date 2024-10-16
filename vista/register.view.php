<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrar-se</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <h1>Enregistrar-se</h1>

    <form action="../controlador/register.controller.php" method="POST">
        <label for="username">Nom d'usuari:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="equip">Equip favorit:</label>
        <select id="equip" name="equip" required>
            <option value="">-- Selecciona el teu equip favorit --</option>
            <option value="FC Barcelona">FC Barcelona</option>
            <option value="Real Madrid">Real Madrid</option>
            <option value="Atlético de Madrid">Atlético de Madrid</option>
            <option value="Sevilla FC">Sevilla FC</option>
            <option value="Valencia CF">Valencia CF</option>
            <option value="Villarreal CF">Villarreal CF</option>
            <option value="Athletic Club">Athletic Club</option>
            <option value="Real Sociedad">Real Sociedad</option>
            <option value="Real Betis">Real Betis</option>
            <option value="Rayo Vallecano">Rayo Vallecano</option>
            <option value="Celta de Vigo">Celta de Vigo</option>
            <option value="CA Osasuna">CA Osasuna</option>
            <option value="RCD Mallorca">RCD Mallorca</option>
            <option value="Girona FC">Girona FC</option>
            <option value="UD Almería">UD Almería</option>
            <option value="Getafe CF">Getafe CF</option>
            <option value="UD Las Palmas">UD Las Palmas</option>
            <option value="Deportivo Alavés">Deportivo Alavés</option>
            <option value="Granada CF">Granada CF</option>
        </select>
        
        <label for="password">Contrasenya:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Enregistrar-se">
    </form>

    <a href="index.php">Tornar a la pàgina principal</a>
</body>
</html>
