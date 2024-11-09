# PreguntasMatch

**PreguntasMatch** es una aplicación web diseñada para explorar y compartir opiniones a través de tests. A diferencia de los tests tradicionales, en los que hay respuestas correctas o incorrectas, aquí se celebran las perspectivas individuales y las opiniones diversas. Los usuarios pueden ver cómo sus respuestas comparan con las de otros, obteniendo una visión única de cómo piensan otras personas sobre temas tanto comunes como inesperados. 

## ✨ Características del Sitio

1. **Tests Iniciales**: Los usuarios comienzan su experiencia explorando una variedad de tests base en diferentes categorías. Estos tests son creados para introducir a los usuarios en la dinámica del sitio.
   
2. **Tests Personalizables**: Los usuarios pueden crear y compartir sus propios tests, ayudando a ampliar las categorías de la aplicación y personalizando la experiencia.
   
3. **Resultados Globales**: Para cada test, los usuarios pueden ver una visualización de resultados, mostrando la distribución de opiniones entre otros usuarios. Esto permite que los usuarios conozcan cómo sus opiniones se alinean (o contrastan) con las de los demás.

## 📁 Estructura del Proyecto
```
project-root
├── index.php                # Página principal
├── categories.php           # Página de categorías de tests
├── user.php                 # Página de perfil del usuario
├── ajax/                    # Funciones AJAX para manejo dinámico de datos
├── assets/                  # Archivos de estilos, imágenes, iconos, y scripts JS
│   ├── css/                 # Estilos CSS personalizados
│   ├── img/                 # Imágenes de portada y categoría
│   ├── js/                  # Scripts JavaScript personalizados
├── BD/                      # Archivos SQL para estructura de la base de datos
├── lib/                     # Funciones PHP de ayuda
├── models/                  # Modelos de datos de PHP para entidades como Usuario, Test, etc.
├── uploads/                 # Archivos subidos por los usuarios
└── views/                   # Archivos de plantillas HTML
```

## 🚀 Instalación

Para ejecutar este proyecto localmente, necesitarás Docker y `docker-compose`. 

1. **Clona el repositorio**:

    ```bash
    git clone https://github.com/JoseLuisAriasHC/PreguntasMatch.git
    cd PreguntasMatch
    ```

2. **Construye la imagen Docker**:

    ```bash
    docker build -t PreguntasMatch .
    ```

3. **Ejecuta el contenedor**:

    ```bash
    docker run -d -p 80:80 PreguntasMatch
    ```

4. **Accede a la aplicación**: Abre un navegador y navega a `http://localhost`.

## 🔧 Tecnologías Utilizadas

- **HTML, CSS, JavaScript**: Para crear una interfaz de usuario atractiva y accesible.
- **PHP y MySQL**: PHP es el backend principal, mientras que MySQL gestiona la base de datos.
- **Bootstrap**: Asegura un diseño responsivo y moderno.
- **FontAwesome**: Proporciona iconos personalizables en toda la aplicación.
- **AOS y OwlCarousel2**: Para animaciones y carruseles de contenido interactivo.
- **jQuery**: Facilita la manipulación del DOM y la interacción de los usuarios.

## 🌍 Despliegue

Este proyecto se ha diseñado para desplegarse en servicios como [Render](https://render.com/) o cualquier otro proveedor compatible con Docker. Para configurarlo:

1. **Definir variables de entorno** en la plataforma de despliegue, como las credenciales de base de datos.
2. **Configurar almacenamiento persistente** para los datos de usuario (si fuera necesario).
3. **Asegurarse de que el puerto 80 esté expuesto** para el tráfico HTTP.
