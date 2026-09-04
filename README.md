# Pizarra

Tablero de tareas tipo Kanban — Proyecto Integrador.

Este README es la **guía general** del proyecto. El detalle día a día (qué hacer y qué entregar) está en:

**https://github.com/Erickpe8/Pizarra/projects**

---

## 1. Objetivo del producto

Construir **Pizarra**, un tablero de tareas con **Laravel 13**, **Tailwind CSS** y entorno **Docker**.

La aplicación debe permitir, como mínimo:

- Gestionar **roles** (por ejemplo líder y trabajadores).
- Que alguien pueda **crear un equipo**.
- Que otras personas puedan **unirse a su equipo**.
- Que un **líder** (u otro rol con permiso) **asigne tareas** a diferentes personas.
- Que las tareas tengan **estados** (por ejemplo por hacer, en progreso, terminada) y se puedan mover en el tablero.

---

## 2. Qué aprenderás

No se trata solo de “hacer una app”: **aprenderás haciendo**. Al construir Pizarra practicarás:

- Lógica de **roles** y **permisos** (quién puede crear, asignar, editar o ver).
- Arquitectura **MVC** en Laravel (modelos, vistas, controladores).
- Plantillas con **Blade**.
- Estilos e interfaz con **Tailwind CSS**.
- El framework **Laravel** en un proyecto real.
- **Git** y **Git Flow** (ramas, commits y un Pull Request por día).
- Cómo trabajan los **equipos de desarrollo**: tareas claras, revisión de código y entrega continua.

---

## 3. Ritmo de trabajo

- Trabajarás aproximadamente **4 horas por día**.
- Cada día debes abrir un **Pull Request** para revisión.
- Trabaja las tareas **en orden**. No avances a la siguiente sin haber abierto el PR del día.

---

## 4. Dónde están tus tareas

Todas las actividades están aquí:

**https://github.com/Erickpe8/Pizarra/projects**

Cada tarjeta indica:

- Qué debes hacer ese día.
- Cuál es el **entregable**.
- El Pull Request correspondiente.

Lee la tarea **antes** de codear.

---

## 5. Preparación del entorno

### Git

Si aún no lo tienes:

- Descarga e instala Git: https://git-scm.com/downloads
- Verifica en la terminal:

```bash
git --version
```

Configura tu nombre y correo (usa el de tu cuenta de GitHub):

```bash
git config --global user.name "Tu Nombre"
git config --global user.email "tu-correo@ejemplo.com"
```

### Docker (obligatorio)

Este proyecto viene **dockerizado**. No necesitas instalar PHP, Composer, MySQL ni Node en tu máquina para desarrollar.

Instala:

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (Windows o Mac)

Verifica:

```bash
docker --version
docker compose version
```

Docker Desktop debe estar **encendido** antes de levantar el proyecto.

---

## 6. Primeros pasos en el repositorio

### Clonar este repositorio

Debes trabajar **sobre este repositorio**:

```bash
git clone https://github.com/Erickpe8/Pizarra.git
cd Pizarra
```

### Configurar variables de Docker

```bash
cp .env.docker.example .env.docker
```

- `.env.docker` → puertos y MySQL de Compose (**no lo subas a Git**).
- `.env` → lo creará Laravel; debe usar `DB_HOST=mysql`.

### Levantar el entorno Docker

```bash
docker compose build
docker compose up -d
```

Servicios:

| Servicio | Para qué sirve | URL / puerto |
|----------|----------------|--------------|
| `nginx` + `app` | Laravel (PHP 8.3 FPM) | http://localhost:8080 |
| `mysql` | Base de datos | `localhost:3306` |
| `node` (perfil `frontend`) | Vite / Tailwind | http://localhost:5173 |

### Crear el proyecto en Laravel 13 (dockerizado)

Sigue la tarea en https://github.com/Erickpe8/Pizarra/projects

Crea Laravel 13 dentro de este repo con Docker. No borres `docker/`, `docker-compose.yml` ni este README.

```bash
bash docker/bin/create-laravel.sh
```

Luego:

```bash
docker compose up -d
```

App: http://localhost:8080

Frontend (cuando exista `package.json`):

```bash
docker compose --profile frontend up -d node
```

### Comandos útiles

```bash
docker compose exec app php artisan migrate
docker compose exec app composer install
docker compose exec app bash
docker compose logs -f
docker compose down
```

No elimines `docker/` ni `docker-compose.yml`.

---

## 7. Cómo entregar cada día (Git Flow)

1. Parte **siempre desde `main`** (esa es la rama base montada en el repositorio).
2. Actualiza `main` y crea una rama por tarea con este formato:

```text
feature/tk#-descripcion
```

Ejemplos: `feature/tk1-setup-laravel`, `feature/tk2-modelo-tablero`.

```bash
git checkout main
git pull origin main
git checkout -b feature/tk#-descripcion
```

3. Haz commits claros y pequeños.
4. Sube la rama y abre un **Pull Request hacia `develop`** (base: `develop`, compare: tu rama). El PR se llama igual que la rama.
5. Espera la revisión. El resto del flujo (merge, integración, etc.) lo maneja tu mentor.

---

## 8. Reglas generales

- No subas archivos sensibles (`.env`, credenciales, etc.).
- No trabajes ni hagas commits directo en `main` ni en `develop`.
- Crea tu rama desde `main` y dirige el PR a `develop`, con el nombre `feature/tk#-descripcion`.
- **No actualices este README** a menos que la tarea del día lo diga específicamente.
- **No borres** `docker/`, `docker-compose.yml`, `.env.docker.example`, `vercel.json`, `Dockerfile.vercel` ni `Caddyfile`.
- Si te trabas más de 30 minutos, documenta el problema en el PR o en un comentario de la issue.

---

## 9. Despliegue en Vercel

Producción: https://pizarra-taupe.vercel.app/

El repo de GitHub ya está conectado a Vercel. **Cada merge a `main` despliega automáticamente.**

Archivos de producción (no los borres):

- `vercel.json`
- `Dockerfile.vercel`
- `Caddyfile`

Cuando exista Laravel, el mentor configura en Vercel al menos:

- `APP_KEY`
- `APP_URL=https://pizarra-taupe.vercel.app`
- Variables de base de datos externa (`DB_*`)

Sin Laravel (`composer.json`) el build de contenedor no puede completar. Primero crea el proyecto (tarea TK1) y luego el deploy a `main` levantará la app.

---

## 10. Recursos útiles

Usa estos recursos cuando te trabes. Empieza por la documentación oficial.

| Tema | Enlace |
|------|--------|
| Tareas día a día | https://github.com/Erickpe8/Pizarra/projects |
| Documentación oficial de Laravel | https://laravel.com/framework/docs/documentation |
| Guía de comandos Artisan | https://www.cursosdesarrolloweb.es/blog/artisan-comandos-laravel-guia-completa |
| Flowbite + Laravel (Tailwind) | https://flowbite.com/docs/getting-started/laravel/ |
| Componentes Flowbite | https://flowbite.com/ |
| Documentación JSDoc | https://jsdoc.app/ |
| Tutorial de Git Flow | https://www.datacamp.com/tutorial/gitflow |
| Playlist de apoyo (YouTube) | https://www.youtube.com/watch?v=FMsXJ84SRr4&list=PLZ2ovOgdI-kVtF2yQ2kiZetWWTmOQoUSG |
| Docker Desktop | https://www.docker.com/products/docker-desktop/ |
| Laravel Sail (referencia) | https://laravel.com/docs/13.x/sail |
| Laravel en Vercel (Docker) | https://vercel.com/kb/guide/laravel-php-with-docker |
