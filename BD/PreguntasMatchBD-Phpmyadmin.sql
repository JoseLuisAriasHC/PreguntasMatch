-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: localhost    Database: preguntasmatch
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `answers` (
  `idAnswer` int NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `idQuestion` int DEFAULT NULL,
  PRIMARY KEY (`idAnswer`),
  KEY `idQuestion_idx` (`idQuestion`),
  CONSTRAINT `idQuestion` FOREIGN KEY (`idQuestion`) REFERENCES `questions` (`idQuestion`)
) ENGINE=InnoDB AUTO_INCREMENT=637 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (31,'Homer Simpson',6),(32,'Bart Simpson',6),(33,'Montgomery Burns',6),(34,'Marge Simpson',6),(35,'Lisa Simpson',6),(36,'Sideshow Bob',6),(37,'Moe Szyslak',6),(38,'Ralph Wiggum',6),(39,'Fat Tony',6),(40,'Ned Flanders',7),(41,'Montgomery Burns',7),(42,'Fat Tony',7),(43,'Joe Quimby',7),(44,'Reverendo Lovejoy',7),(45,'Apu',7),(46,'Montgomery Burns',8),(47,'Sideshow Bob',8),(48,'Nelson Muntz',8),(49,'Fat Tony',8),(50,'Santa\'s Little Helper',9),(51,'Willie',9),(52,'Homer Simpson',9),(53,'Marge Simpson',9),(54,'Abraham Simpson',10),(55,'Moe Szyslak',10),(56,'Milhouse Van Houten',11),(57,'Ralph Wiggum',11),(58,'Barney Gumble',12),(59,'Helen Lovejoy',12),(60,'Elizabeth Hoover',12),(61,'Hijos de Flanders',12),(62,'Ralph Wiggum',13),(63,'Barney Gumble',13),(64,'Homer Simpson',14),(65,'Bart Simpson',14),(66,'Marge Simpson',14),(67,'Lisa Simpson',14),(68,'Maggie Simpson',14),(360,'Rojo',129),(361,'Verde',129),(362,'Amarillo',129),(363,'blanco',129),(364,'Negro',129),(365,'Gris',129),(366,'Azul',129),(367,'Morado',129),(368,'Naranja',129),(369,'1',130),(370,'2',130),(371,'3',130),(372,'4',130),(373,'5',130),(374,'6',130),(375,'7',130),(376,'8',130),(377,'9',130),(378,'Antigua',131),(379,'Nueva',131),(380,'Italiano',132),(381,'Mexicano',132),(382,'Japones',132),(383,'KFC',132),(384,'McDonald\'s',132),(385,'Burger king',132),(386,'Kebab',132),(387,'Prefiero ver Series',133),(388,'Prefiero ver Películas',133),(389,'Me da igual que ver',133),(390,'Matemáticas',134),(391,'Lengua',134),(392,'Ingles',134),(393,'Educación Física',134),(394,'Biología',134),(395,'Geografía e Historia',134),(396,'Informática',134),(397,'Arcangel #54',135),(398,'Duki #50',135),(399,'Quevedo #52',136),(400,'Villano Antillano #51',136),(401,'Tiago PZK #48',137),(402,'Snow the product #39',137),(403,'Morad #47',138),(404,'Trueno #16',138),(405,'Dani #24',139),(406,'Alemán #15',139),(407,'Nicki Nicole #13',140),(408,'Ptazeta #45',140),(409,'Nathy Peluso #36',141),(410,'Eladio Carrion #40',141),(411,'Shakira #53',142),(412,'Peso Pluma #55',142),(413,'Residente #49',143),(414,'Nicki Jam #41',143),(415,'Khea #34',144),(416,'C.R.O #29',144),(417,'ColdPlay',145),(418,'Imagine Dragons',145),(419,'Lady Gaga',146),(420,'Beyonce',146),(421,'Rauw alejandro',147),(422,'Quevedo',147),(423,'María Becerro',148),(424,'NIcki NIcole',148),(425,'Shakira',149),(426,'Rihanna',149),(427,'Adele',150),(428,'Billie Ellish',150),(429,'Guns N Roses',151),(430,'Red Hot Chili Peppers',151),(431,'Daddy Yankee',152),(432,'Don Omar',152),(433,'Queen',153),(434,'Michael Jackson',153),(435,'Ed Sheeren',154),(436,'Shawn Mendes',154),(437,'MacDonals',155),(438,'Starbucks',155),(439,'KFC',155),(440,'SubWay',155),(441,'Dominos Pizza',155),(442,'Pizza Hut',155),(443,'Burger King',155),(444,'Taco Bell',155),(445,'Sushi',156),(446,'Yakitori',156),(447,'Kaiseki',156),(448,'Udon',156),(449,'Soba',156),(450,'Sukiyaki',156),(451,'Sashimi',156),(452,'Paella',157),(453,'Tortilla de patata',157),(454,'Gazpacho',157),(455,'Pulpo a la gallega',157),(456,'Croquetas',157),(457,'Churros con chocolate',157),(458,'Fabada',157),(459,'Cordero al chilindrón',157),(460,'Cocido madrileño',157),(461,'El Mole',158),(462,'El Pozole',158),(463,'Cochinita Pibil',158),(464,'Chiles en Nogada',158),(465,'Barbacoa',158),(466,'Carnitas',158),(467,'Pescado a la talla',158),(468,'Tacos',158),(469,'Coca-Cola',159),(470,'Pepsi',159),(471,'Sprite',159),(472,'Fanta',159),(473,'Dr. Peppe',159),(474,'7UP',159),(475,'Gatorade',159),(476,'Red Bull',159),(477,'Tiramisú',160),(478,'Crema catalana',160),(479,'Cheesecake',160),(480,'Pavlova',160),(481,'Alfajores',160),(482,'Tarta Sacher',160),(483,'Gelato',160),(484,'Mochi ',160),(485,'Waffles',160),(486,'Creo que representan una nueva forma de invertir y pueden revolucionar el sistema financiero.',161),(487,'Me preocupa su volatilidad y el impacto ambiental de la minería de criptomonedas.',161),(488,'No estoy seguro',161),(489,' necesito más información para formar una opinión.',161),(490,'Pienso que pueden conectar a personas de todo el mundo y ser una herramienta poderosa para el cambio social.',162),(491,'Me preocupa el aumento de la adicción a las redes sociales y la propagación de información errónea.',162),(492,'Depende del uso que se le dé; pueden ser positivas o negativas según cómo las utilicemos.',162),(493,'Es esencial para abordar la desigualdad sistémica y construir un mundo más justo e inclusivo.',163),(494,'Creo que ha generado conversaciones importantes',163),(495,' pero todavía hay mucho trabajo por hacer para lograr un cambio real.',163),(496,'No estoy muy familiarizado con el tema',163),(497,' pero estoy dispuesto a aprender más al respecto.',163),(498,'Creo que ofrece más flexibilidad y un mejor equilibrio entre el trabajo y la vida personal.',164),(499,'Me preocupa la desconexión social y la pérdida de la colaboración en persona en los entornos laborales.',164),(500,'\"Depende de la industria y el tipo de trabajo',164),(501,' pero creo que ha llegado para quedarse en cierta medida.',164),(502,'Creo que es alarmante y necesitamos buscar alternativas más sostenibles en la moda.',165),(503,'Me preocupa la explotación laboral y el desperdicio de recursos en la industria de la moda rápida.',165),(504,'Es un problema importante',165),(505,' pero creo que los consumidores también tienen un papel importante en impulsar el cambio.',165),(506,'Prefiero el fútbol porque me encanta la emoción de ver partidos internacionales y el ambiente en los estadios.',166),(507,'Me inclino más hacia el baloncesto porque disfruto de la velocidad del juego y la habilidad de los jugadores para encestar desde cualquier posición.',166),(508,'Creo que Lionel Messi es el mejor jugador de la historia porque su habilidad técnica y visión de juego son incomparables.',167),(509,'Para mí',167),(510,' Cristiano Ronaldo es el mejor jugador de todos los tiempos debido a su capacidad atlética',167),(511,' su ética de trabajo y su capacidad para marcar en cualquier situación.',167),(512,'Prefiero el tenis porque disfruto viendo los emocionantes intercambios entre los jugadores y la intensidad de los partidos.',168),(513,'Me gusta más el golf porque encuentro relajante ver a los jugadores competir en campos hermosos y estratégicos',168),(514,'Creo que ayuda a garantizar decisiones más justas y precisas',169),(515,' aunque a veces puede ralentizar el juego.',169),(516,'Me preocupa que la tecnología pueda quitarle la emoción y la controversia al deporte',169),(517,' y que los errores humanos formen parte de su encanto.',169),(518,'Michael Jordan es el mejor jugador de baloncesto de todos los tiempos debido a su impacto en el juego y su habilidad para ganar campeonatos.',170),(519,'LeBron James es el mejor jugador de baloncesto de todos los tiempos porque su versatilidad y habilidades en todas las áreas del juego son incomparables.',170),(520,'Me parece emocionante y refleja la evolución de los intereses deportivos a nivel global.',171),(521,'Me preocupa que la inclusión de deportes más \'extremos\' pueda alejar la atención de los valores olímpicos tradicionales.',171),(522,'Inteligencia Artificial (IA)',172),(523,'Realidad Virtual (RV) y Realidad Aumentada (RA)',172),(524,'Blockchain y criptomonedas',172),(525,'Vehículos autónomos y conducción asistida',172),(526,'Internet de las cosas (IoT)',172),(527,'Computación cuántica',172),(528,'Biología sintética y edición genética',172),(529,'Reemplazarán gradualmente a los combustibles fósiles como la principal fuente de energía.',173),(530,'Complementarán las fuentes de energía tradicionales',173),(531,' pero no las reemplazarán por completo.',173),(532,'Serán la principal fuente de energía en algunas regiones del mundo',173),(533,' pero no en todas.',173),(534,'Aunque importantes',173),(535,' no alcanzarán a satisfacer completamente la demanda global de energía.',173),(536,'Habrá un aumento significativo en la educación en línea y la enseñanza remota.',174),(537,'Se producirá una mayor personalización del aprendizaje gracias a la tecnología.',174),(538,'Surgirán nuevas formas de evaluación y certificación de habilidades.',174),(539,'Habrá una mayor integración de la tecnología en el aula',174),(540,' como realidad virtual y realidad aumentada.',174),(541,'Automatizará muchas tareas rutinarias',175),(542,' lo que podría llevar a la pérdida de empleos en algunas industrias.',175),(543,'Creará nuevas oportunidades laborales en campos relacionados con la inteligencia artificial y la tecnología.',175),(544,'Cambiará la naturaleza de muchos trabajos',175),(545,' pero no necesariamente resultará en una disminución del empleo en general.',175),(546,'Será necesaria una reconversión laboral y una mayor adaptabilidad por parte de los trabajadores para mantenerse relevantes en el mercado laboral.',175),(547,'Intentaría hablar con mi amigo para entender por qué mintió y resolver la situación',176),(548,'Podría sentirme decepcionado',176),(549,' pero trataría de perdonar y reconstruir la confianza si la amistad es importante para mí.',176),(550,'Dependería de la gravedad de la mentira; podría reconsiderar la amistad si siento que no puedo confiar en esa persona.',176),(551,'Creo que puede funcionar si hay una comunicación sólida y un compromiso mutuo.',177),(552,'Puede ser difícil',177),(553,' pero vale la pena si ambos están dispuestos a hacer el esfuerzo y a mantenerse conectados.',177),(554,'No estoy seguro/a',177),(555,' creo que depende de la situación individual y de la capacidad de ambos para manejar la distancia',177),(556,'Buscaría ayuda profesional para mi familiar y lo apoyaría en todo lo posible durante su recuperación.',178),(557,'Intentaría hablar abiertamente con mi familiar sobre su situación y lo alentaría a buscar ayuda.',178),(558,'Podría ser difícil para mí aceptar la situación al principio',178),(559,' pero haría todo lo posible para apoyar a mi familiar y educarme sobre la salud mental',178),(560,'Lo discutiríamos juntos y evaluaríamos cómo afectaría nuestra relación y nuestras metas individuales.',179),(561,'Podría ser una oportunidad emocionante para ambos',179),(562,' pero también consideraría los desafíos y sacrificios que implicaría.',179),(563,'Me sentiría preocupado/a por la distancia',179),(564,' pero si es importante para mi pareja',179),(565,' haría todo lo posible para apoyar su decisión.',179),(566,'Me negaría a mentir por mi amigo y trataría de encontrar una solución alternativa al problema.',180),(567,'Intentaría entender por qué mi amigo me pide que mienta y le expresaría mi preocupación por las posibles consecuencias.',180),(568,'Dependería de la situación; si la mentira no es grave y no lastima a nadie',180),(569,' podría considerarlo',180),(570,' pero preferiría ser honesto/a en general',180),(571,'Cancún',181),(572,' México',181),(573,'Bali',181),(574,' Indonesia',181),(575,'Santorini',181),(576,' Grecia',181),(577,'Maui',181),(578,' Hawái',181),(579,'Phuket',181),(580,' Tailandia',181),(581,'Maldivas',181),(582,'La ceremonia del té en Japón',182),(583,'La danza del tango en Argentina',182),(584,'La celebración del Festival de Holi en India',182),(585,'La observación de la aurora boreal en Islandia',182),(586,'La visita a las ruinas de Machu Picchu en Perú',182),(587,'La exploración de los templos de Angkor Wat en Camboya',182),(588,'Nueva York',183),(589,' Estados Unidos',183),(590,'Tokio',183),(591,' Japón',183),(592,'Barcelona',183),(593,' España',183),(594,'Bangkok',183),(595,' Tailandia',183),(596,'Berlín',183),(597,' Alemania',183),(598,'Buenos Aires',183),(599,' Argentina',183),(600,'Que hace frío todo el año',184),(601,'Que la gente es poco amigable o seria',184),(602,'Que es un país peligroso debido a la percepción de la corrupción',184),(603,'Que la comida es poco apetitosa o poco variada',184),(604,'Que la vida cotidiana es sombría y austera',184),(605,'Que la política y la cultura son opresivas',184),(606,'Queenstown',185),(607,' Nueva Zelanda (bungee jumping y paracaidismo)',185),(608,'Interlaken',185),(609,' Suiza (parapente y ala delta)',185),(610,'Moab',185),(611,' Utah',185),(612,' Estados Unidos (escalada en roca y mountain bike)',185),(613,'Cairns',185),(614,' Australia (buceo en la Gran Barrera de Coral)',185),(615,'Costa Rica (tirolesa y surf en aguas bravas)',185),(616,'Nepal (senderismo y montañismo en el Himalaya)',185),(617,'Un RPG de mundo abierto con una historia inmersiva y mucha exploración.',186),(618,'Un juego de acción y aventuras con gráficos impresionantes y combate desafiante.',186),(619,'Un juego de estrategia por turnos que me permita planificar y ejecutar tácticas complejas.',186),(620,'Un juego multijugador en línea con una gran comunidad y actualizaciones regulares.',186),(621,'\"Me encanta la saga de \'The Legend of Zelda\' por su narrativa épica y sus desafiantes mazmorras.\"',187),(622,'\"Prefiero la serie \'Final Fantasy\' por sus mundos fantásticos y personajes inolvidables.\"',187),(623,'\"Soy fanático de \'Super Mario\' porque sus juegos son divertidos y accesibles para jugadores de todas las edades.\"',187),(624,'\"Me gusta \'Call of Duty\' por su acción intensa y su emocionante modo multijugador.\"',187),(625,'\"Prefiero \'The Witcher 3: Wild Hunt\' por su historia más profunda y personajes más complejos.\"',188),(626,'\"\'Skyrim\' es mi elección porque su mundo abierto es más expansivo y ofrece más libertad de elección.\"',188),(627,'\"Depende de lo que busque; \'The Witcher 3\' es mejor para la narrativa',188),(628,' mientras que \'Skyrim\' destaca en la exploración y personalización.\"',188),(629,'\"Me encanta jugar con Link de \'The Legend of Zelda\' porque es valiente',189),(630,' habilidoso y tiene un sentido del deber.\"',189),(631,'\"Prefiero a Geralt de Rivia de \'The Witcher\' porque es un personaje complejo con un trasfondo fascinante y habilidades únicas.\"',189),(632,'\"Sonic the Hedgehog es mi favorito porque es rápido',189),(633,' divertido y siempre está en busca de aventuras emocionantes.\"',189),(634,'\"Me encantaría ver una adaptación de \'Mass Effect\' por su vasto universo y sus historias emocionantes.\"',190),(635,'\"\'The Last of Us\' sería genial como serie de televisión debido a su narrativa intensa y sus personajes conmovedores.\"',190),(636,'\"Una película basada en \'Red Dead Redemption\' sería increíble por su ambientación del Salvaje Oeste y su historia épica.\"',190);
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `idCategory` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` mediumtext NOT NULL,
  PRIMARY KEY (`idCategory`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Comida-Bebida','Preguntas sobre platos y comidas favoritas.Preguntas sobre restaurantes y tipos de cocina preferidos.Preguntas sobre recetas y habilidades culinarias.'),(2,'Creatividad-Imaginacion','Preguntas sobre qué harían si tuvieran superpoderes.Preguntas sobre inventar historias o mundos ficticios.Preguntas irreales para este mundo.'),(3,'Cultura-Sociedad','Preguntas sobre eventos actuales y noticias.Preguntas sobre cultura popular y tendencias.Preguntas sobre temas sociales y cuestiones importantes.'),(4,'Deportes','Pregunta sobre comparar jugadores.Pregunta sobre que deporte es mejor.Pregunta sobre el deporte favorito.'),(5,'Futuro-Metas','Preguntas sobre maquinas del futuro.Pregunta sobre que cosas dejaran de existir.Pregunta sobre la evolución.Pregunta que pasaria si hago esto.'),(6,'Conocimiento general','Preguntas sobre eventos históricos y figuras históricas.Preguntas sobre ciencia, tecnología y avances recientes.Preguntas sobre datos curiosos y hechos interesantes.'),(7,'Musica','Pregunta de música favorita.Pregunta de el mejor cantante.Pregunta sobre el mejor estilo musical.Pregunta comparando artistas'),(8,'Peliculas-Series','Pregunta sobre mejor serie.Pregunta sobre serie favorita.Pregunta sobre Pelicula que más me ha hecho llorar.Comparar peliculas y series'),(9,'Relaciones personales','Preguntas sobre amistad, familia y relaciones amorosas.Preguntas sobre situaciones, que pasaria si.Preguntas sobre que seria peor.Preguntas sobre que me sorprenderia más.'),(10,'Valores-Etica','Preguntas sobre cuestiones éticas y dilemas morales.Preguntas sobre valores personales y principios.Preguntas sobre cómo afrontar situaciones éticas.'),(11,'Viajes-Aventuras','Preguntas sobre destinos de viaje favoritos.Preguntas sobre experiencias de viaje y anécdotas.Preguntas sobre prejuicios de un país.'),(12,'Videojuegos','Preguntas sobre videojuego favorito.Preguntas sobre comparar un videojuego.Preguntas sobre hipoteticos videojuegos.');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `idQuestion` int NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `idTest` int NOT NULL,
  `idCategory` int NOT NULL,
  PRIMARY KEY (`idQuestion`),
  KEY `idTest_idx` (`idTest`),
  KEY `idCategory_idx` (`idCategory`),
  CONSTRAINT `idCategory` FOREIGN KEY (`idCategory`) REFERENCES `categories` (`idCategory`),
  CONSTRAINT `idTest` FOREIGN KEY (`idTest`) REFERENCES `test` (`idTest`)
) ENGINE=InnoDB AUTO_INCREMENT=191 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (6,'¿Con cuál de sus protagonistas te sientes identificado?',2,2),(7,'¿A que personaje matarías?',2,8),(8,'¿Qué personaje te parece que es el malo de la serie?',2,10),(9,'¿Qué personaje salvarias?',2,10),(10,'¿De estos personajes cual prefieres?',2,8),(11,'¿Qué vida prefieres llevar de estos personajes?',2,10),(12,'¿Cuál es el personajes mas irrelevante de la serie?',2,8),(13,'¿Quién crees que es más tonto?',2,10),(14,'¿A que personaje de la familia de los Simpson cambiarias?',2,2),(129,'Color favorito',13,2),(130,'Numero favorito',13,2),(131,'Música favorita',13,7),(132,'¿Qué restaurante prefieres?',13,1),(133,'Series vs Peliculas',13,8),(134,'Materia Favorita en la escula',13,6),(135,'Salva una acción Edición BizaRrap',14,7),(136,'Salva una acción Edición BizaRrap',14,7),(137,'Salva una acción Edición BizaRrap',14,7),(138,'Salva una acción Edición BizaRrap',14,7),(139,'Salva una acción Edición BizaRrap',14,7),(140,'Salva una acción Edición BizaRrap',14,7),(141,'Salva una acción Edición BizaRrap',14,7),(142,'Salva una acción Edición BizaRrap',14,7),(143,'Salva una acción Edición BizaRrap',14,7),(144,'Salva una acción Edición BizaRrap',14,7),(145,'¿Qué cantante Prefieres?',15,7),(146,'¿Qué cantante Prefieres?',15,7),(147,'¿Qué cantante Prefieres?',15,7),(148,'¿Qué cantante Prefieres?',15,7),(149,'¿Qué cantante Prefieres?',15,7),(150,'¿Qué cantante Prefieres?',15,7),(151,'¿Qué cantante Prefieres?',15,7),(152,'¿Qué cantante Prefieres?',15,7),(153,'¿Qué cantante Prefieres?',15,7),(154,'¿Qué cantante Prefieres?',15,7),(155,'¿Qué prefieres? (Restaurantes rapitos)',16,1),(156,'¿Qué prefieres? (Comida Japonesa)',16,1),(157,'¿Qué prefieres? (Comida Española)',16,1),(158,'¿Qué prefieres? (Comida Mexicana)',16,1),(159,'¿Qué prefieres? (Refrescos)',16,1),(160,'¿Qué prefieres? (Postres)',16,1),(161,'¿Qué opinas sobre el auge de las criptomonedas como el Bitcoin?',17,3),(162,'¿Cómo crees que las redes sociales están afectando a la sociedad?',17,3),(163,'¿Cuál es tu opinión sobre el movimiento de justicia racial en los Estados Unidos?',17,3),(164,'¿Qué opinas sobre el crecimiento del trabajo remoto como resultado de la pandemia?',17,3),(165,'¿Qué piensas sobre el impacto ambiental de la industria de la moda rápida?',17,3),(166,'¿Prefieres el fútbol o el baloncesto?',18,4),(167,'¿Crees que Lionel Messi o Cristiano Ronaldo es el mejor jugador de fútbol de la historia?',18,4),(168,'¿Te gusta más el tenis o el golf y por qué?',18,4),(169,'¿Cuál es tu opinión sobre el uso de la tecnología en el deporte, como el VAR en el fútbol?',18,4),(170,'¿Quién crees que es el mejor jugador de baloncesto de todos los tiempos: Michael Jordan o LeBron James y por qué?',18,4),(171,'¿Qué piensas sobre la inclusión de nuevos deportes en los Juegos Olímpicos, como el surf o el skateboarding?',18,4),(172,'¿Cuál crees que será la tecnología más influyente en los próximos 10 años?',19,5),(173,'¿Qué papel crees que jugarán las energías renovables en el futuro de la energía?',19,1),(174,'¿Cómo crees que evolucionará la educación en los próximos años?',19,1),(175,'¿Qué impacto crees que tendrá la inteligencia artificial en el futuro del empleo?',19,1),(176,'¿Qué harías si descubrieras que un amigo te mintió sobre algo importante?',20,9),(177,'¿Qué opinas sobre mantener una relación amorosa a larga distancia?',20,9),(178,'¿Qué pasaría si descubrieras que un miembro de tu familia está teniendo problemas de salud mental?',20,9),(179,'¿Cómo reaccionarías si tu pareja expresara el deseo de mudarse a otro país por motivos de trabajo?',20,9),(180,'¿Qué harías si un amigo te pide que mientas por él/ella?',20,1),(181,'¿Cuál es tu destino de playa favorito para vacacionar?',21,11),(182,'¿Qué experiencia cultural te impactó más durante tus viajes?',21,11),(183,'¿Cuál es tu destino urbano favorito para explorar la vida nocturna y la gastronomía?',21,11),(184,'¿Qué prejuicios crees que existen sobre el país de Rusia?',21,11),(185,'¿Cuál es tu destino de aventura favorito para practicar deportes extremos?',21,11),(186,'¿Qué tipo de videojuego preferirías comprar en este momento?',22,12),(187,'¿Cuál es tu franquicia de videojuegos favorita y por qué?',22,12),(188,'¿Qué juego crees que es mejor: \'The Witcher 3: Wild Hunt\' o \'Skyrim\'?',22,12),(189,'¿Cuál es tu personaje jugable favorito de todos los tiempos y por qué?',22,1),(190,'¿Qué juego te gustaría ver adaptado a una película o serie de televisión?',22,1);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `test` (
  `idTest` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `idUser` int NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`idTest`),
  KEY `idUser_idx` (`idUser`),
  CONSTRAINT `idUser` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test`
--

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
INSERT INTO `test` VALUES (2,'Preguntas sobre la serie de Televisión Los Simpson','Este es un Test para ver tus preferencias sobre los personajes y acontecimientos sobre La serie Los Simpson.','LosSimpson.jpg',4,'2024-02-11'),(13,'Preguntas Random','Este es un test de preguntas frecuentes y ver en que porcentaje estas.','random.png',8,'2024-03-07'),(14,'Salva una acción Edición BizaRrap','Te vamos a dar a elegir entre 2 opciones de canciones de BizaRrap y la mejor se salva.','biza.jpg',4,'2024-03-07'),(15,'¿Qué cantante Prefieres?','En este test tienes que elegir entre 2 cantantes famosos para ver cual es el más popular.','cantantes.jpg',5,'2024-03-07'),(16,'Elige solo lo mejor Edición Comida','Se presentaras distintos platos/restaurantes/bebidas y tienes que elegir solo el mejor.','plato.jpg',6,'2024-03-07'),(17,'Preguntas de actualidad','Estas son preguntas de cierta importancia social y cultural que puede repercutir a toda la población.','bitcoin.jpg',4,'2024-03-13'),(18,'Puro deporte','preguntas sobres deportes, comparativas y otras controversiales.','campo.jpg',4,'2024-03-13'),(19,'Preguntas esencias para el futuro','Cuestiones sobre el futuro IA, la educación y el empleo.','futuro.jpg',4,'2024-03-13'),(20,'Cuestiones de las relaciones','Preguntas un tanto conflictivas que puedes llegar a vivirlo en algún momentos de tu vida.','gente.jpg',4,'2024-03-13'),(21,'Mis preguntas sobre viajes','Preguntas sobre destinos, aventuras, prejuicios etc.','viaje.jpg',4,'2024-03-13'),(22,'La cultura de los videojuegos','tipo de juegos, franquicias, comparar juegos, personajes etc.','juegos.jpg',4,'2024-03-13');
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_of_the_day`
--

DROP TABLE IF EXISTS `test_of_the_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `test_of_the_day` (
  `idTestOfTheDay` int NOT NULL AUTO_INCREMENT,
  `idTest` int NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`idTestOfTheDay`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_of_the_day`
--

LOCK TABLES `test_of_the_day` WRITE;
/*!40000 ALTER TABLE `test_of_the_day` DISABLE KEYS */;
INSERT INTO `test_of_the_day` VALUES (2,2,'2024-03-01'),(3,13,'2024-03-07');
/*!40000 ALTER TABLE `test_of_the_day` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_answers`
--

DROP TABLE IF EXISTS `user_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_answers` (
  `idUserAnswer` int NOT NULL AUTO_INCREMENT,
  `idUser` int DEFAULT NULL,
  `idTest` int NOT NULL,
  `idQuestion` int NOT NULL,
  `idSelectedAnswer` int NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`idUserAnswer`),
  KEY `idUser_idx` (`idUser`),
  KEY `idTest_idx` (`idTest`),
  KEY `idQuestion_idx` (`idQuestion`),
  KEY `idAnswer_idx` (`idSelectedAnswer`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_answers`
--

LOCK TABLES `user_answers` WRITE;
/*!40000 ALTER TABLE `user_answers` DISABLE KEYS */;
INSERT INTO `user_answers` VALUES (25,4,2,6,31,'Me identifico en la panza','2024-02-26 16:35:09'),(26,4,2,7,40,'Sospecho que es malo y tu?','2024-02-26 16:35:09'),(27,4,2,8,47,'Se pensamos igual es porque sabes que mata a sangre fria','2024-02-26 16:35:09'),(28,4,2,9,50,'Tu también quieres mas a los perros que a las personas jajajaja','2024-02-26 16:35:09'),(29,4,2,10,55,'Me da mucha pena que no le salga bien nada','2024-02-26 16:35:09'),(30,4,2,11,57,'Tu también piensa que la debe pasar bien loco, no?','2024-02-26 16:35:09'),(31,4,2,12,60,'Para mi es la maestra de Lisa y punto','2024-02-26 16:35:09'),(32,4,2,13,63,'jajaja no elegiste al otro por pena ','2024-02-26 16:35:09'),(33,4,2,14,66,'Siento que le falta algo pero no se el que, para ti que le falta?','2024-02-26 16:35:09'),(34,4,13,129,366,NULL,'2024-03-07 15:26:12'),(35,4,13,130,376,NULL,'2024-03-07 15:26:12'),(36,4,13,131,379,NULL,'2024-03-07 15:26:12'),(37,4,13,132,386,NULL,'2024-03-07 15:26:12'),(38,4,13,133,389,NULL,'2024-03-07 15:26:12'),(39,4,13,129,366,'El azul me hace recordar al cielo','2024-03-12 15:40:12'),(40,5,13,129,364,NULL,'2024-03-07 15:28:22'),(41,5,13,130,369,'hay que ser el primero en todo','2024-03-07 15:28:22'),(42,5,13,131,379,'Todo lo nuevo es mejor','2024-03-07 15:28:22'),(43,5,13,132,384,'Es confiable y barato','2024-03-07 15:28:22'),(44,5,13,133,388,'Son mas cortas e igual de emocionantes','2024-03-07 15:28:22'),(45,5,13,134,394,'jajaja, igual era la única materia que entendía','2024-03-07 15:28:22'),(46,6,13,129,362,NULL,'2024-03-07 15:30:37'),(47,6,13,130,377,'Es el número mas alto','2024-03-07 15:30:37'),(48,6,13,131,378,'Antes las canciones eran mejores','2024-03-07 15:30:37'),(49,6,13,132,380,NULL,'2024-03-07 15:30:37'),(50,6,13,133,387,'Están mejor elaboradas','2024-03-07 15:30:37'),(51,6,13,134,390,'Son pura lógica ¿verdad?','2024-03-07 15:30:37'),(52,4,13,130,369,NULL,'2024-03-12 15:40:12'),(53,4,13,131,379,NULL,'2024-03-12 15:40:12'),(54,4,13,132,386,NULL,'2024-03-12 15:40:12'),(55,4,13,133,387,NULL,'2024-03-12 15:40:12'),(56,4,13,134,390,NULL,'2024-03-12 15:40:12');
/*!40000 ALTER TABLE `user_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `icon` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `pwd_UNIQUE` (`pwd`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'user1','user1@gmail.com','$2y$10$vLXC9huTTZEvw8Jl9.4re.JtaOFszhGPydhR5kK..C/2ssgHBZfm6','icon_N(1).png'),(5,'user2','user2@gmail.com','$2y$10$Z2sVHEtwY2BlRa./mIbKI.wopkUdyI871KLUZpUdqNH8IbFOXEkvO','icon_N(7).png'),(6,'user3','user3@gmail.com','$2y$10$mDoY8JMKqicMXSPVbESI4.seQz.pI7UTKry88gKKMwrKoh136Ffoq','icon_N(22).png'),(7,'user5','user5@gmail.com','$2y$10$9Z4zvAt7tMr4/NdYM3fI9.IX1l/iEp/J2oRJLPyktQdk0FOnZeYbK','icon_N(60).png'),(8,'user4','user4@gmail.com','$2y$10$5NDG7haKb9HByiq/q9pnr.jiSgBpLKDVxfCi.SZaA7UUETAA5wQRm','icon_N(97).png'),(9,'user0','user0@gmail.com','$2y$10$PIjleHy8u6YT6LR.qAJFg.04JDckF1esSFjVlKDIU0fzkuCqA..82','icon_N(83).png'),(10,'user6','user6@gmail.com','$2y$10$Bbu4Lv4oOYi3Jyp0xoo72O0C6mQWgYP1DRj3S.o49OzK2P0ejkxvm','icon_N(42).png');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'preguntasmatch'
--
/*!50106 SET @save_time_zone= @@TIME_ZONE */ ;
/*!50106 DROP EVENT IF EXISTS `create_test_of_the_day` */;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8mb4 */ ;;
/*!50003 SET character_set_results = utf8mb4 */ ;;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`root`@`localhost`*/ /*!50106 EVENT `create_test_of_the_day` ON SCHEDULE EVERY 1 DAY STARTS '2024-02-28 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DECLARE today DATE;
    SET today = CURDATE();

    INSERT INTO test_of_the_day (idTest, date)
    SELECT top_tests.idTest, CURDATE()
    FROM (
        SELECT ua.idTest, COUNT(*) AS total_responses
        FROM user_answers ua
        WHERE ua.date >= DATE_SUB(today, INTERVAL 7 DAY) -- Filtrar respuestas de la última semana
        GROUP BY ua.idTest
        ORDER BY total_responses DESC -- Ordenar por la cantidad de respuestas
    ) AS top_tests
    LEFT JOIN test_of_the_day tod ON top_tests.idTest = tod.idTest
    WHERE tod.idTestOfTheDay IS NULL -- Filtrar test que aún no están en test_of_the_day
    LIMIT 1; -- Seleccionar solo el primer test disponible que no está en test_of_the_day
END */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
DELIMITER ;
/*!50106 SET TIME_ZONE= @save_time_zone */ ;

--
-- Dumping routines for database 'preguntasmatch'
--
/*!50003 DROP PROCEDURE IF EXISTS `create_test_of_the_day` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_test_of_the_day`()
BEGIN
    DECLARE today DATE;
    SET today = CURDATE();

    INSERT INTO test_of_the_day (idTest, date)
    SELECT top_tests.idTest, CURDATE()
    FROM (
        SELECT ua.idTest, COUNT(*) AS total_responses
        FROM user_answers ua
        WHERE ua.date >= DATE_SUB(today, INTERVAL 7 DAY) -- Filtrar respuestas de la última semana
        GROUP BY ua.idTest
        ORDER BY total_responses DESC -- Ordenar por la cantidad de respuestas
    ) AS top_tests
    LEFT JOIN test_of_the_day tod ON top_tests.idTest = tod.idTest
    WHERE tod.idTestOfTheDay IS NULL -- Filtrar test que aún no están en test_of_the_day
    LIMIT 1; -- Seleccionar solo el primer test disponible que no está en test_of_the_day
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-18 10:54:33
