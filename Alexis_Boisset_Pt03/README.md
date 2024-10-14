# Gestor d'Articles amb Paginació

Aquest projecte consisteix en una aplicació web per a la gestió d'articles, que permet crear, editar, eliminar i llistar articles desats en una base de dades. La pàgina inclou paginació per a facilitar la navegació a través dels articles disponibles.

## Estructura del Projecte

## Estructura del projecte

Aquesta es l'estructura del projecte, amb la seva funcionalitat.

```
controlador/
    ├── delete.php          # Elimina registres del sistema
    ├── list.php            # Llista els registres disponibles
    ├── logout.php          # Gestiona la sortida dels usuaris
    └── save.php            # Desa nous registres o actualitza els existents
model/
    └── database.php        # Configuració i connexió a la base de dades
styles/
    ├── styles_crear.css    # Estils específics per a la pàgina de creació
    ├── styles_llistar.css  # Estils específics per a la pàgina de llistat
    └── styles.css          # Estils generals del projecte
vista/
    ├── crear.php           # Interfície per crear nous registres
    ├── eliminar.php        # Interfície per eliminar registres
    ├── index.vista.php     # Pàgina principal de la vista
    ├── indexplantilla.php  # Plantilla base per a les vistes
    └── Ilistar.php         # Interfície per llistar registres
index.php                   # Pàgina principal del projecte
Pt03_Alexis_Boisset.sql     # Script SQL per a la base de dades
```
## Connexió a la Base de Dades

La connexió a la base de dades es realitza utilitzant PDO. El codi està preparat per capturar qualsevol error durant la connexió amb un bloc `try...catch`. En cas de produir-se un error, es farà servir `die()` per aturar l'execució.

La crida a la base de dades es fa de la següent manera:

```php
try {
    $conn = new PDO("mysql:host=localhost;dbname=pt03_Nom_Cognom", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la connexió: " . $e->getMessage());
}
```
## Funcionalitats Principals

### Crear i Editar Articles (crear.php)

**Objectiu:** Permet la creació i edició d’articles. Si es proporciona un ID existent, s’editarà l’article corresponent; si no, es crearà un nou article.

**Funcionament:** L’usuari omple un formulari amb el títol i la descripció de l’article. El formulari s’envia per POST a la base de dades. Si l’ID està buit o és nou, es crearà un nou article, i si l’ID ja existeix, es farà una actualització de l’article.

**Validació:** El formulari valida que els camps de títol i descripció no estiguin buits abans de l’enviament.

### Eliminar Articles (eliminar.php)

**Objectiu:** Permet eliminar un article de la base de dades.

**Funcionament:** L’usuari introdueix l’ID de l’article que vol eliminar i, si aquest existeix, es procedeix a la seva eliminació.

### Paginació d’Articles (index.php)

**Objectiu:** Mostrar els articles en pàgines amb un màxim de 5 articles per pàgina.

**Funcionament:** Es calcula el total d’articles i es divideix entre el número d’articles per pàgina (5) per determinar el número total de pàgines. L’usuari pot navegar entre les pàgines utilitzant botons de “Anterior” i “Següent”.

**Implementació:**
- La paginació es gestiona a través de variables que determinen la pàgina actual i ajusten les consultes SQL per obtenir els articles adequats.
- El botó “Anterior” es deshabilita si l’usuari es troba a la primera pàgina, i el botó “Següent” es deshabilita si l’usuari es troba a l’última pàgina.
- Si no es troben articles, l’usuari és redirigit a la pàgina principal.

## Autor

- Alexis Boisset
