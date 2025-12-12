## Inicio

<p>Para iniciar este proyecto debes asegurarte de seguir las siguientes instrucciones
para configurar correctamente el entorno.</p>
<p>Revisa el archivo .env.example para que tengas una idea de como tratar tu propio archivo .env</p>

## Requisitos

Necesitas tener Composer y Laravel instalados, en la ultima versión.
Necesitas tener Node y NPM instalados en la ultima versión estable.

## Base de Datos

<p>En un archivo .env configurar correctamente los campos relacionados a la conexión a
base de datos.</p>

- **Seleccionar el tipo de conexión mysql**
- **Configurar el puerto, host, base de datos, usuario y contraseña**
- **En una terminal, en la raíz del proyecto, ejecuta el comando `php artisan migrate`**
- **Después, ejecuta el comando `php artisan db:seed` para cargar los datos iniciales**

## Compilación
En una terminal, en la raíz del proyecto, ejecuta el comando `npm install` para instalar todas las
dependencias del proyecto.

## Inicio del servidor

En una terminal, en la raíz del proyecto ejecuta el comando `php artisan key:generate` y copia la
clave generada en el campo APP_KEY de tu archivo .env, luego ejecuta el comando `php artisan serve`
y en el navegador busca <em>http://localhost:8000/</em> la cual sera la liga para nuestra pagina.

## Usuarios de prueba

### Usuario

- **Nombre: Jane Doe**
- **Correo: user@melodic.com**
- **Contraseña: password**

### Artista independiente

- **Nombre: John Doe**
- **Correo: artist@melodic.com**
- **Contraseña: password**

### Label

- **Nombre: Melodic Records**
- **Correo: label@melodic.com**
- **Contraseña: password**

### Administrador

- **Nombre: Administrador**
- **Correo: admin@melodic.com**
- **Contraseña: admin123**
