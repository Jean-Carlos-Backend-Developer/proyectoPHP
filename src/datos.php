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
];

/*UD 3.3.a
Construcción del array asociativo con productos de los mas real posible con imagen distita para cada uno 
para luego poder usarlo en la página productos.php*/

$productos = [
    [
        "id" => 1,
        "nombre" => "MacBook Pro",
        "descripcion" => "Portátil de alto rendimiento con chip M2",
        "imagen" => "static/images/macbookpro.jpeg",
        "precio" => 399.99,
        //Añadiendo fecha que pedia en el ejercicio UD 3.3b
        "fecha" => "15/11/2023",
        "categorias" => [1, 5]
    ],
    [
        "id" => 6,
        "nombre" => "Asus ROG Ally",
        "descripcion" => "PC híbrido con gráfica dedicada NVIDIA",
        "imagen" => "static/images/rog-ally.webp",
        "precio" => 120.22,
        "fecha" => "10/10/2023",
        "categorias" => [1, 3]
    ],
    [
        "id" => 4,
        "nombre" => "iPhone 14 Pro",
        "descripcion" => "Teléfono móvil de nueva generación",
        "imagen" => "static/images/iphone14pro.jpg",
        "precio" => 650.35,
        "fecha" => "20/09/2023",
        "categorias" => [2]
    ],
    [
        "id" => 8,
        "nombre" => "Samsung Galaxy S23",
        "descripcion" => "Smartphone Android de gama alta",
        "imagen" => "static/images/galaxys29.jpg",
        "precio" => 1480.99,
        "fecha" => "30/08/2023",
        "categorias" => [2]
    ],
    [
        "id" => 7,
        "nombre" => "PlayStation 5",
        "descripcion" => "Consola de videojuegos de última generación",
        "imagen" => "static/images/ps5.jpg",
        "precio" => 650.49,
        "fecha" => "25/07/2023",
        "categorias" => [3]
    ],
    [
        "id" => 3,
        "nombre" => "Xbox Series X",
        "descripcion" => "Consola potente con soporte para juegos en 4K",
        "imagen" => "static/images/xboxseriesx.jpg",
        "precio" => 399.99,
        "fecha" => "15/06/2023",
        "categorias" => [3]
    ],
    [
        "id" => 5,
        "nombre" => "AirPods Pro",
        "descripcion" => "Auriculares inalámbricos con cancelación de ruido",
        "imagen" => "static/images/Airpods.jpg",
        "precio" => 225.32,
        "fecha" => "05/05/2023",
        "categorias" => [4]
    ],
    [
        "id" => 2,
        "nombre" => "Logitech MX Master 3",
        "descripcion" => "Ratón inalámbrico ergonómico y preciso",
        "imagen" => "static/images/logitech.jpg",
        "precio" => 89.99,
        "fecha" => "01/04/2023",
        "categorias" => [4]
    ]
];

//UD 3.3.f 
//El código recorre el array de productos y divide los 8 productos en 2 arrays, luego cada uno de esos arrays se codifican para crear
//dos ficheros jSON usando la funcion json_encode a la que le pasamos el array y JSON_PRETTY_PRINT para que los cree de forma "legible".
//Después leemos ambos ficheros y lo unimos usado array_merge para crear u solo array.

$fichero1 = "productos1.json";
$fichero2 = "productos2.json";
$productos1 = [];
$productos2 = [];

foreach ($productos as $indice => $producto) {
    if ($indice <= 3) {
        $productos1[] = $producto;
    } else {
        $productos2[] = $producto;
    }
}

//Codificación de los arrays a JSON
$miJson1 = json_encode($productos1, JSON_PRETTY_PRINT);
$miJson2 = json_encode($productos2, JSON_PRETTY_PRINT);

//Si el fichero no existe lo crea y escribe en el contenido del JSON
if (!file_exists($fichero1)) {
    if (file_put_contents($fichero1, $miJson1) !== false) {
    } 
}

if (!file_exists($fichero2)) {
    if (file_put_contents($fichero2, $miJson2) !== false) {
    }
}

//Leemos ambos fichero JSON creado anteriormente y los decodifica creando un array por cada fichero,
//para después con array_merge crear un solo array que une ambos arrays.
$miArray1 = json_decode(file_get_contents($fichero1),true);
$miArray2 = json_decode(file_get_contents($fichero2),true);
$miArrayFinal = array_merge($miArray1, $miArray2);

//echo var_dump($miArrayFinal); //Linea que me sirve para ver que hay e el array

?>

<?php
/*UD 3.2.c
Creación de la variable donde se almacene el nombre y el apellido para luego usarlo
en el h3 de la página contacto*/
$nombre = [
    "name" => "Jean Carlos",
    "surname" => "Espín"
];
?>

<?php
/*UD 3.2.e
Creación de una variable boleana para que en caso que sea verdadera muestre una nueva 
opción llamada "Administración" en el menú de navegación luego en el archivo header.php
se hace el include de datos.php y se usa la variable $loggedIn en un condicional para mostrar 
no la nueva opción en el menú de navegación.*/
$loggedIn = true;
?>