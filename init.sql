DROP DATABASE Shop;
CREATE DATABASE Shop default charset cp1251;
USE Shop;

CREATE TABLE category (
     id smallint not null auto_increment,
     name varchar(32) not null,
     primary key (id)
);

CREATE TABLE car ( 
    id smallint unsigned not null auto_increment, 
    primary key (id),
    name varchar(20) not null, 
    category_id smallint not null,
    FOREIGN KEY (category_id) references category (id),
    year smallint not null,
    price mediumint not null,
    engine varchar(100) not null,
    transmission varchar(100) not null,
    weight varchar(100) not null,
    description text
)
COLLATE='utf8_general_ci';

CREATE TABLE user (
     id int not null auto_increment,
     primary key (id),
     password longtext not null ,
     email varchar(32) not null,
     role varchar(32) not null
);


CREATE TABLE orders (
     id int not null auto_increment primary key,
     status boolean not null,
     user_id int not null,
     CONSTRAINT user_id_fk FOREIGN KEY (user_id) references user (id)
);


CREATE TABLE order_item (
     id int auto_increment primary key,
     order_id int not null,
     CONSTRAINT order_id_fk FOREIGN KEY (order_id) references orders (id),
     car_id smallint unsigned not null,
     CONSTRAINT car_id_fk FOREIGN KEY (car_id) references car (id),
     quantity smallint not null
);



-- INSERT INTO user ( email, password, role ) 
--     VALUES 
--         ( 'admin@admin.com', 'admin', 'admin' ),
--         ( 'user1@user.com', 'user1', 'user'),
--         ( 'user2@user.com', 'user2', 'user'),
--         ( 'user3@user.com', 'user3', 'user'),
--         ( 'user4@user.com', 'user4', 'user');

INSERT INTO category ( name ) VALUES ('Sedan'), ('Uni'), ('Hatch'), ('Coupe');

INSERT INTO car ( name, category_id, year, price, engine, transmission, weight, description ) 
    VALUES 
        ('Mazda 3', 1, 2016, 21166, "1.6L бензиновый 105 л.с.", '5-скор МКПП ', '1278', 'Третье поколение было представлено 26 июня 2013 года в автосалоне в Австралии. Автомобиль построен на новом шасси Skyactiv, которым заменили платформу C1 от Ford. Появился новый дизайн кузова, который создан согласно идеологии марки, называется KODO — Дух движения и абсолютно новый интерьер. Автомобиль получил новые двигатели Skyactiv — 1.5 литра SkyActiv-G I4 бензиновый 118 л. с., 2.0 литра SkyActiv-G I4 бензиновый 155 л. с., 2.5 литра SkyActiv-G I4 бензиновый 184 л. с. и 2.2 L SkyActiv-D I4 турбо дизель 150 л. с., которые работают в паре с 6-ступенчатой механической коробкой передач и 6-ступенчатой автоматической коробкой передач.' ),
        ('Mazda 6', 1, 2014, 23333, '2,0L SKYACTIV-G 150 л. с.', '6-скор. МКПП', '1400', 'Mazda 6 (в связи с ограничениями на использование цифр в торговых марках автомобилей применяется слитное написание Mazda6) — среднеразмерный автомобиль японской компании Mazda. Выпускается с 2002 года. В Японии и Китае продается под названием Mazda Atenza. Предшественником модели считается Mazda 626, так же известная как Mazda Capella. Mazda 6 первого поколения стала первым представителем нового модельного ряда Mazda. За ней последовали Mazda 2 в декабре 2002 года, RX-8 в августе 2003 года, Mazda 3 в январе 2004 года, Mazda 5 летом 2005 года.'),
        ('Mazda 6 Wagon', 2, 2018, 33413, '2,0L SKYACTIV-G 150 л. с.', '6-скор. МКПП', '1400', 'Mazda 6 Wagon – передне- или полноприводный универсал среднеразмерной категории, который может похвастать привлекательным дизайном, высоким уровнем практичности и современной технической составляющей… Он адресован, в первую очередь, семейным людям с одним или несколькими детьми, проживающим в городской среде…'),
        ('Mazda 626', 2, 2002, 5000, 'бензиновый 1,6 л L4', 'Механическая 4-ступ.', '1005', 'Mazda Capella — компактный автомобиль, разработанный и производившийся японской компанией Mazda Motor Corporation c 1970 по 2002 год. На европейском и американском рынках известен как Mazda 626. На базе этого автомобиля, Ford Motor Company были созданы Ford Telstar и Ford Probe.'),
        ('Mazda 323F', 3, 1998, 3000, 'бензиновый мотор 1.3л 75 л.с.', '5-скор МКПП ', '1340', 'В пятом поколении, представленном в 1994 году, была продолжена традиция разного дизайна для разных типов кузовов: у седана была традиционная невыразительная внешность, а трех- и пятидверных хэтчбеков — запоминающийся спортивный облик. '),
        ('Mazda RX-8', 4, 2005, 9000, '1,3л RENESIS (роторный двигатель)', '6-ступ. АКПП', '1373', 'Mazda RX-8 — спортивный автомобиль производства японской компании Mazda, преемник модели RX-7. Четырёхместное заднеприводное спорт-купе с распашными дверями без стойки. Кажется, что в машине только две двери, но если открыть переднюю дверь, виден рычаг для открытия задней двери. RX-8 выпускалась в Японии с 2003 по 2012 год.'),
        ('Mazda MX-5', 4, 2018, 20000, 'бензин 160 л.с 2.0л', '5-скор МКПП ', '1200', 'Mazda MX-5 / Miata — родстер, появившийся в 1989 году, выпускающийся компанией Mazda. Разработка велась совместно с инженерами компании Lotus Cars, в результате автомобиль унаследовал главные черты классических британских спортивных автомобилей (легкий вес, двигатель внутри колёсной базы, задний привод, простота конструкции).');

