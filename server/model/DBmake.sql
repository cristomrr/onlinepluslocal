-- Eliminamos base de datos
-- DROP DATABASE IF EXISTS onlinepluslocal;

-- Creamos la base de datos con el conjunto de carácteres deseado
-- CREATE DATABASE onlinepluslocal CHARACTER SET = 'utf8mb4' COLLATE = 'utf8mb4_unicode_520_ci';

-- Elegimos la base de datos a utilizar
USE onlinepluslocal;

-- Creamos la tabla de usuarios (Vendedores y Clientes)
CREATE TABLE users( 
    `id` INT PRIMARY KEY auto_increment,
    `username` VARCHAR ( 255 ),
    `document` VARCHAR ( 255 ) comment 'Vendedores: CIF / Clientes: DNI',
    `type` enum('seller', 'buyer') comment 'Tipo de usuario registrado',
    `phone` VARCHAR ( 255 ),
    `email` VARCHAR ( 255 ),
    `address` VARCHAR ( 255 ),
    `city` VARCHAR ( 255 ),
    `province` VARCHAR ( 255 ),
    `password` VARCHAR ( 255 )
) engine = innodb CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_520_ci';

-- Creamos la tabla de artículos (M->1)
CREATE TABLE articles( 
    `id` INT PRIMARY KEY auto_increment,
    `name` VARCHAR ( 255 ),
    `img` VARCHAR ( 255 ),
    `description` VARCHAR ( 255 ),
    `price` VARCHAR ( 255 ),
    `idusers` INT,
    CONSTRAINT `fk_article_user` FOREIGN KEY ( idusers ) REFERENCES users(id) ON DELETE CASCADE
) engine = innodb CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_520_ci';

-- Creamos la tabla de favoritos (M->M)
CREATE TABLE favorites( 
    `id` INT PRIMARY KEY auto_increment,
    `idusers` INT,
    `idarticles` INT,
    CONSTRAINT `fk_favorites_users` FOREIGN KEY ( idusers ) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT `fk_favorites_articles` FOREIGN KEY ( idarticles ) REFERENCES articles(id) ON DELETE CASCADE
) engine = innodb CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_unicode_520_ci';

-- Insertamos usuarios de tipo vendedor
INSERT INTO users(`id`, `username`, `document`, `type`, `phone`, `email`, `address`, `city`, `province`, `password`)
VALUES ( 
         null,
         'Taifa',
         'Q2826000H',
         'seller',
         '+34 657838394',
         'taifa@mail.com',
         'C. Castillo, 24',
         'Adeje',
         'Tenerife',
         'ropa2022' ),
       ( 
         null,
         'Juguetes Anthony',
         'T5686123K',
         'seller',
         '+34 922864784',
         'jugarymas@mail.com',
         'Av. de los Vientos, 12',
         'Adeje',
         'Tenerife',
         'juguetes2022' ),
       ( 
         null,
         'Roche Bobois',
         'J5626120N',
         'seller',
         '+34 922630912',
         'roche@mail.com',
         'C. Atalaya, 7',
         'Adeje',
         'Tenerife',
         'muebles2022' );

         -- Insertamos usuarios de tipo cliente
INSERT INTO users(`id`, `username`, `document`, `type`, `phone`, `email`, `address`, `city`, `province`, `password`)
VALUES ( 
         null,
         'Eva',
         'D4827800L',
         'buyer',
         '+34 876465788',
         'eva@mail.com',
         'C. Adanes, 124',
         'Adeje',
         'Tenerife',
         'eva2022' );
        
-- Insertamos artículos pertenecientes a la tienda Taifa
INSERT INTO articles(`id`, `name`, `img`, `description`, `price`, `idusers`)
VALUES ( 
         null,
         'Falda blanca',
         './assets/users/1/1.jpg',
         'Falda blanca ligera para el verano con tallas XS hasta XXL',
         '25$',
         1 ),
       ( 
         null,
         'Falda azul mar',
         './assets/users/1/2.jpg',
         'Falda azul muy ligera de varios colores con tallas XS hasta XXL',
         '20$',
         1 ),
       ( 
         null,
         'Falda negro cuadros',
         './assets/users/1/3.jpg',
         'Falda negra de lana con cuadros blancos tallas X hasta XXL',
         '28$',
         1 ),
       ( 
         null,
         'Peluca oscura',
         './assets/users/1/4.jpg',
         'Peluca de color oscura, con flequillo y muy natural',
         '18$',
         1 ),
       ( 
         null,
         'Camisa blanca',
         './assets/users/1/5.jpg',
         'Camisa blanca con mangas negras tallas XS a XL',
         '10$',
         1 ),
       ( 
        null,
         'Camisa azul Hana Montana',
         './assets/users/1/6.jpg',
         'Camisa azul con el dibujo de Hana Montana',
         '8$',
         1 ),
       ( 
         null,
         'Vaquero corto',
         './assets/users/1/7.jpg',
         'Vaquero corto de mujer, tallas XS a XL',
         '15$',
         1 );
    
-- Insertamos artículos pertenecientes a la tienda Juguetes y más
INSERT INTO articles(`id`, `name`, `img`, `description`, `price`, `idusers`)
VALUES ( 
         null,
         'Astronauta',
         './assets/users/2/8.jpg',
         'Juguete de astronauta que planea al lanzar',
         '15$',
         2 ),
       ( 
         null,
         'Oso peluche',
         './assets/users/2/9.jpg',
         'Osito de pechuche muy alegre',
         '12$',
         2 ),
       ( 
         null,
         'Set Mario Bros',
         './assets/users/2/10.jpg',
         'Set de piezas de Mario Bros Company',
         '32$',
         2 ),
       ( 
         null,
         'Conejo peluche',
         './assets/users/2/11.jpg',
         'Conejo de peluche que habla al tirar de la oreja, disponible varios colores',
         '19$',
         2 );
         
-- Insertamos artículos pertenecientes a la tienda Roche Bobois
INSERT INTO articles(`id`, `name`, `img`, `description`, `price`, `idusers`)
VALUES ( 
         null,
         'Platos mayas',
         './assets/users/3/13.jpg',
         'Juego de platos con pinturas mayas',
         '35$',
         3 ),
       ( 
         null,
         'Set sillas y mesas ext',
         './assets/users/3/14.jpg',
         'Conjunto de 2 sillas y una mesa para piscina o zona exterior, muy decorada',
         '62$',
         3 ),
       ( 
         null,
         'Florero madera interior',
         './assets/users/3/15.jpg',
         'florero de madera de interior minimalista',
         '21$',
         3 ),
       ( 
         null,
         'Florero inca de pared',
         './assets/users/3/16.jpg',
         'Floreros incas de pared, de color blanco beige de buena calidad',
         '39$',
         3 );

         -- Insertamos un favorito
         INSERT INTO favorites(`id`, `idusers`, `idarticles`) VALUES(1,1,1);