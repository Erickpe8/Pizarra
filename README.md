# Pizarra

Tablero de tareas tipo Kanban — Proyecto Integrador.

Este README es la **guía general** del proyecto. El detalle día a día (qué hacer y qué entregar) está en:

**https://github.com/Erickpe8/Pizarra/projects**

---

## 1. Objetivo del producto

Construir **Pizarra**, un tablero de tareas con **Laravel** y **Tailwind CSS**.

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

### Herramientas para Laravel

Asegúrate de tener instalado:

- [PHP](https://www.php.net/downloads) (versión compatible con Laravel actual)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) (para el frontend / Vite)
- Una base de datos local (por ejemplo MySQL o SQLite)

Verifica:

```bash
php -v
composer -V
node -v
npm -v
```

---

## 6. Primeros pasos en el repositorio

### Clonar este repositorio

Debes trabajar **sobre este repositorio**:

```bash
git clone https://github.com/Erickpe8/Pizarra.git
cd Pizarra
```

### Crear el proyecto en Laravel

Dentro de este repositorio clonado, crea el proyecto Laravel **tal como lo indica la tarea** en Projects:

https://github.com/Erickpe8/Pizarra/projects

Sigue los pasos y el entregable de esa tarea. No inventes otro flujo: clona este repo, lee la tarea y crea Laravel donde y como ella lo especifique.

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
- Si te trabas más de 30 minutos, documenta el problema en el PR o en un comentario de la issue.

---

## 9. Recursos útiles

| Tema | Enlace |
|------|--------|
| Tareas día a día | https://github.com/Erickpe8/Pizarra/projects |
| Documentación de Laravel | https://laravel.com/framework/docs/documentation |
| Componentes Tailwind (Flowbite) | https://flowbite.com/ |
| Tutorial de Git Flow | https://www.datacamp.com/tutorial/gitflow |

Ante cualquier duda de Laravel, consulta primero la documentación oficial. Para la interfaz con Tailwind, Flowbite te facilitará mucho el trabajo visual.
