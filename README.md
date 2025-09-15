<p align="center">
  <a href="#"><img alt="PHP" src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white"/></a>
  <a href="#"><img alt="MySQL" src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white"/></a>
  <a href="#"><img alt="JavaScript" src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black"/></a>
</br>
  <a href="#"><img alt="XAMPP" src="https://img.shields.io/badge/XAMPP-FB7A24?style=for-the-badge&logo=xampp&logoColor=white"/></a>
  <a href="#"><img alt="Docker" src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white"/></a>
</p>

# 📊 Download Stats Panel

<p align="center">
  <img src="https://github.com/martinezdom/DownloadStatsPanel/blob/main/httpdocs/layout/backend/images/logo.png?raw=true" alt="Logo" width="200"/>
</p>

**Proyecto Final de Grado (TFG)**  
Plataforma web para visualizar y gestionar estadísticas de descarga de aplicaciones y documentos.

---

## 🔍 ¿Qué es DownloadStatsPanel?

DownloadStatsPanel es una plataforma web desarrollada como Proyecto Final de Grado que permite visualizar y gestionar estadísticas de descarga de aplicaciones y documentos. Ofrece una interfaz intuitiva y responsive para analizar datos de descargas segmentadas por diferentes criterios.

---

## 🧩 Estructura del proyecto

```
📂 DownloadStatsPanel/
├── bd/
│   ├── download_stats_panel.sql
├── config/
│   ├── httpd.conf
├── httpdocs/
│   ├── app/
│   │   ├── config/
│   ├── layout/
│   │   ├── backend/
│   │   │   ├── config/
│   │   │   ├── functions/
│   │   │   ├── images/
│   │   │   │   ├── icons/
│   │   │   │   ├── logo.png
│   │   │   ├── js/
│   │   │   ├── section/
│   │   │   ├── style/
│   │   │   ├── template/
│   │   │   │   ├── includes/
│   │   │   │   ├── footer.php
│   │   │   │   ├── head.php
│   │   │   │   ├── header.php
│   │   │   ├── index.php
│   │   │   ├── login.php
│   ├── .htaccess
│   ├── index.php
├── README.md
├── docker-compose.yml
├── Dockerfile
```

---

## 🚀 Despliegue

### 1️⃣ Usando XAMPP ⚙️

Para una configuración más profesional y limpia sin depender de la carpeta `htdocs`, te recomiendo usar un **Virtual Host**. Esto te permitirá acceder al proyecto con una URL personalizada como `downloadstatspanel.local`.

1.  **Instala XAMPP:**
    Descarga e instala [XAMPP](https://www.apachefriends.org/es/index.html) en tu sistema operativo.

2.  **Activa las Extensiones de PHP:**
    Abre el archivo `php.ini` desde el panel de control de XAMPP. Descomenta (elimina el `;` al principio de la línea) las siguientes extensiones:
    ```ini
    ;extension=mbstring
    ;extension=mysqli
    ```

3.  **Crea el Virtual Host:**
    Edita el archivo de configuración de Virtual Hosts de Apache. Lo encontrarás en la ruta `xampp/apache/conf/extra/httpd-vhosts.conf`. Al final del archivo, añade el siguiente bloque:
    ```apache
    <VirtualHost *:80>
        ServerName downloadstatspanel.local
        DocumentRoot "[RUTA_ABSOLUTA_A_TU_PROYECTO]/httpdocs"
        ErrorLog "logs/downloadstatspanel_error.log"
        CustomLog "logs/downloadstatspanel_access.log" common
        <Directory "[RUTA_ABSOLUTA_A_TU_PROYECTO]/httpdocs">
		      Options Indexes FollowSymLinks Includes ExecCGI
		      AllowOverride All
		      Require all granted
        </Directory>
    </VirtualHost>
    ```
    ⚠️ **Importante:** Reemplaza `[RUTA_ABSOLUTA_A_TU_PROYECTO]` por la ruta completa a la carpeta de tu proyecto. Por ejemplo, en Windows podría ser `C:/xampp/htdocs/DownloadStatsPanel`, o en macOS/Linux `/Applications/XAMPP/htdocs/DownloadStatsPanel`.

4.  **Configura el Archivo `hosts`:**
    Para que tu navegador reconozca `downloadstatspanel.local`, debes editar el archivo `hosts` de tu sistema.
    * **Windows:** `C:\Windows\System32\drivers\etc\hosts`
    * **macOS/Linux:** `/etc/hosts`
    Añade la siguiente línea al final del archivo:
    ```
    127.0.0.1 downloadstatspanel.local
    ```

6.  **Ejecuta los Servicios:**
    Inicia **Apache** y **MySQL** desde el panel de control de XAMPP.

7.  **Importa la Base de Datos:**
    Accede a **phpMyAdmin** (http://localhost/phpmyadmin/) desde el navegador y crea una base de datos. Luego, importa el script SQL que se encuentra en  `bd/download_stats_panel.sql`.

8.  **Configura las Credenciales:**
    Abre el archivo `app/config/main_config.php` y actualiza las credenciales de la base de datos si es necesario (el nombre de usuario y la contraseña por defecto de XAMPP son `root` y `''` respectivamente).

9.  **¡Accede al Panel!**
    Ahora puedes acceder al panel de control desde tu navegador usando la URL: `http://downloadstatspanel.local`.

---

### 2️⃣ Usando Docker 🐳

Si prefieres una configuración más rápida y aislada, puedes usar Docker.

1.  **Instala Docker:**
    Asegúrate de tener [Docker](https://www.docker.com/get-started) y Docker Compose instalados en tu sistema.

2.  **Inicia los Contenedores:**
    Abre una terminal en la raíz del proyecto y ejecuta el siguiente comando:
    ```sh
    docker compose up -d --build
    ```
    Este comando construirá la imagen del contenedor, la iniciará en segundo plano (`-d`) y creará los servicios necesarios.

3.  **Accede al Panel:**
    Una vez que los contenedores estén listos, puedes acceder a la aplicación desde tu navegador en la siguiente dirección:
    `http://localhost`

---

### 💡 Nota importante:
Al usar Docker, no necesitas instalar XAMPP. Asegúrate de que los puertos **80** (HTTP) y **3306** (MySQL) estén libres para evitar conflictos con otros programas o servicios que tengas en tu sistema.

---

## 🧠 Funcionalidades destacadas

| Características |
|----------------|
| 📊 **Dashboard Interactivo**: Visualización de estadísticas con gráficos interactivos |
| ✅ Estadísticas filtradas por fecha, documentos o descargas |
| 🔍 **Filtros Avanzados**: Filtrado por fechas, aplicaciones y documentos |
| ✅ Panel de administración intuitivo |
| 📱 **Diseño Responsive**: Compatible con dispositivos móviles y tablets |
| ✅ Uso de gráficos para visualización clara |
| 🔐 **Sistema de Autenticación**: Acceso seguro con usuario y contraseña |
| ✅ Preparado para despliegue en entorno real |
| 🌐 **Arquitectura Modular**: Fácil mantenimiento y escalabilidad|

---

## 🛠️ Tecnologías

- **PHP**
- **MySQL**
- **JavaScript / jQuery**
- **HTML5 + CSS3**
- **Boostrap icons**

---

## 👨‍💻 Autor

Creado por [martinezdom](https://github.com/martinezdom)

[![LinkedIn](https://img.shields.io/badge/LinkedIn-Miguel%20%C3%81ngel%20Mart%C3%ADnez-blue?style=for-the-badge&logo=linkedin)](https://www.linkedin.com/in/martinezdom)

## 📄 Licencia

Este proyecto está bajo la licencia MIT.
