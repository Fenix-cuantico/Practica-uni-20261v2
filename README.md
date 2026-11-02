# Sistema de Gestión Académica - Práctica UNI 2026-I

Aplicación web desarrollada en Laravel 11 para la administración de carga horaria, control de asistencia docente y estudiantil, y generación dinámica de reportes en PDF.

---

## Características

- **Autenticación y Roles**: Control de acceso según perfiles de usuario (`admin`, `teacher`, `student`).
- **Perfil Docente**: Registro y actualización de información personal, datos académicos, carga familiar y datos de contacto.
- **Gestión de Horarios**: Visualización de asignaturas, distribución de aulas, secciones y turnos correspondientes al semestre lectivo.
- **Control de Asistencia**: Registro de marcación docente y pase de lista de alumnos por sesión.
- **Generación de Reportes PDF**: Servicio desacoplado basado en DomPDF que permite exportar fichas de datos y cargas lectivas con configuración de orientación, márgenes, cabeceras y pie de página.

---

## Requisitos

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB (o SQLite para pruebas locales)

---

## Instalación y Puesta en Marcha

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/TU_USUARIO/TU_REPOSITORIO.git
   cd Practica-uni-20261
   ```

2. **Instalar dependencias de PHP:**
   ```bash
   composer install
   ```

3. **Instalar y compilar dependencias de frontend:**
   ```bash
   npm install
   npm run build
   ```

4. **Configurar el archivo de entorno:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configurar la base de datos:**
   Asegúrate de definir la conexión en tu archivo `.env`. Si utilizas MySQL, crea la base de datos (por defecto `uni_sistema`) y ejecuta las migraciones junto con los datos de prueba:
   ```bash
   php artisan migrate --seed
   ```

6. **Iniciar el servidor de desarrollo:**
   ```bash
   php artisan serve
   ```
   La aplicación estará disponible en `http://127.0.0.1:8000`.

---

## Datos de Prueba (Seeders)

Para acceder de forma inmediata en el entorno local, las migraciones configuran la siguiente cuenta de prueba:

- **Rol**: Administrador / Docente
- **Correo**: `patata@gmail.com`
- **Contraseña**: `patata123`
