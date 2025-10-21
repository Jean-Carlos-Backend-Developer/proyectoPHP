<?php
/*UD 3.3.b
Creación de un array asociativo llamado $categorias, en el cual las claves numéricas represetan
el identificador único de cada categoría y luego lo añado como campo nuevo en el array de productos*/
$categorias = [
    1 => "Informática",
    2 => "Telefonía",
    3 => "Gaming",
    4 => "Accesorios",
    5 => "Portátiles",
    6 => "Desconocido",
];

/*UD 3.3.a
Construcción del array asociativo con productos de los mas real posible con imagen distita para cada uno 
para luego poder usarlo en la página productos.php*/

//COMENTADO PORQUE YA USO LOS JSON
$productos = [
    [
        "id" => 1,
        "clave" => "PROD0001",
        "nombre" => "MacBook Pro",
        "descripcion" => "Portátil de alto rendimiento con chip M2",
        "imagen" => "static/images/macbookpro.jpeg",
        "precio" => 399.99,
        "fecha" => "15/11/2021",
        "categorias" => [1, 5]
    ],
    [
        "id" => 6,
        "clave" => "PROD0006",
        "nombre" => "Asus ROG Ally",
        "descripcion" => "PC híbrido con gráfica dedicada NVIDIA",
        "imagen" => "static/images/rog-ally.webp",
        "precio" => 120.22,
        "fecha" => "10/10/2023",
        "categorias" => [1, 3]
    ],
    [
        "id" => 4,
        "clave" => "PROD0004",
        "nombre" => "iPhone 14 Pro",
        "descripcion" => "Teléfono móvil de nueva generación",
        "imagen" => "static/images/iphone14pro.jpg",
        "precio" => 650.35,
        "fecha" => "20/09/2022",
        "categorias" => [2]
    ],
    [
        "id" => 8,
        "clave" => "PROD0008",
        "nombre" => "Samsung Galaxy S23",
        "descripcion" => "Smartphone Android de gama alta",
        "imagen" => "",
        "precio" => 1480.99,
        "fecha" => "30/08/2020",
        "categorias" => [2]
    ],
    [
        "id" => 7,
        "clave" => "PROD0007",
        "nombre" => "PlayStation 5",
        "descripcion" => "Consola de videojuegos de última generación",
        "imagen" => "static/images/ps5.jpg",
        "precio" => 650.49,
        "fecha" => "25/07/2024",
        "categorias" => [3]
    ],
    [
        "id" => 3,
        "clave" => "PROD0003",
        "nombre" => "Xbox Series X",
        "descripcion" => "Consola potente con soporte para juegos en 4K",
        "imagen" => "static/images/xboxseriesx.jpg",
        "precio" => 399.99,
        "fecha" => "15/06/2019",
        "categorias" => [3]
    ],
    [
        "id" => 5,
        "clave" => "PROD0005",
        "nombre" => "AirPods Pro",
        "descripcion" => "Auriculares inalámbricos con cancelación de ruido",
        "imagen" => "static/images/Airpods.jpg",
        "precio" => 225.32,
        "fecha" => "05/05/2025",
        "categorias" => [4]
    ],
    [
        "id" => 2,
        "clave" => "PROD0002",
        "nombre" => "Logitech MX Master 3",
        "descripcion" => "Ratón inalámbrico ergonómico y preciso",
        "imagen" => "static/images/logitech.jpg",
        "precio" => 89.99,
        "fecha" => "01/04/2023",
        "categorias" => [4]
    ]
];

//UD 3.3.g
//Inicialmente, el array $productos estaba sin comentar para poder generar los ficheros JSON 
//(productos1.json y productos2.json) con los datos de los productos. 
//Una vez creados los JSON, se comenta el array para cumplir con el ejercicio, 
//Comprobamos si existen los ficheros JSON con productos. 
//Si no existen, dividimos el array $productos en dos partes, las codificamos a JSON 
//y las guardamos en productos1.json y productos2.json.
//Luego, leemos ambos ficheros, los decodificamos y los unimos con array_merge 
//para reconstruir el array completo de productos.

$fichero1 = __DIR__ . "/mysql/productos1.json";
$fichero2 = __DIR__ . "/mysql/productos2.json";

if (!file_exists($fichero1) || !file_exists($fichero2)) {

    $productos1 = [];
    $productos2 = [];

    foreach ($productos as $indice => $producto) {
        if ($indice <= 3) {
            $productos1[] = $producto;
        } else {
            $productos2[] = $producto;
        }
    }

    //Codificación a JSON
    $miJson1 = json_encode($productos1, JSON_PRETTY_PRINT);
    $miJson2 = json_encode($productos2, JSON_PRETTY_PRINT);

    //Escritura de los ficheros JSON
    file_put_contents($fichero1, $miJson1);
    file_put_contents($fichero2, $miJson2);
}

//Decodifico los array y los guardo en dos fichero json distintos
$productos1 = json_decode(file_get_contents($fichero1), true);
$productos2 = json_decode(file_get_contents($fichero2), true);

$fichero3 = __DIR__ . "/mysql/productos.json";

if (!file_exists($fichero3)) {
    $productosJuntos = array_merge($productos1, $productos2); //Junto ambos ficheros
    //Escribo y codifico el fichero
    file_put_contents($fichero3, json_encode($productosJuntos, JSON_PRETTY_PRINT));
}
//Decodifico el JSON y lo guardo en la variable productos
$productos = json_decode(file_get_contents($fichero3), true);


/*UD 3.2.c
Creación de la variable donde se almacene el nombre y el apellido para luego usarlo
en el h3 de la página contacto*/
$nombre = [
    "name" => "Jean Carlos",
    "surname" => "Espín"
];

/*UD 3.2.e
Creación de una variable boleana para que en caso que sea verdadera muestre una nueva 
opción llamada "Administración" en el menú de navegación luego en el archivo header.php
se hace el include de datos.php y se usa la variable $loggedIn en un condicional para mostrar o
no la nueva opción en el menú de navegación.*/
//$loggedIn = true;