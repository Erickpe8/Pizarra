# Pizarra

Tablero de tareas tipo Kanban — Proyecto Integrador.

Este README es la **guía general** del proyecto. El detalle día a día (qué hacer y qué entregar) está en:

**https://github.com/Erickpe8/Pizarra/projects**

---

## 1. que hace Pizarra 

pizarra permite crear un usuario el cual puede crear equipos y ser lider o por otro lado unirse a un equipo ya existente y ser trabajador, pizarra permite tener mas de un equipo y a su vez pirmite particpar como trabajador en mas de uno tambien, pizarra es una plataforma donde los lideres pueden crear y asignar tareas a los mienbros de sus grupos y estos pueden irlas realizando y colocando segun en la fase de desarrollo que este dicha tarea y a su vesz permite comentar en las tareas para dejar opiniones u observaciones. 


---

## 2. levantarlo en local

para levantarlo es necesario que clone este repositorio atreves de 
-git clone https://github.com/Erickpe8/Pizarra.git 

tambien debes tener instalado Git, PHP, Composer y Node.js

posteriormente debes correr las migraciones 
-docker compose exec app php artisan migrate

y desde el docker acceder a la vista 

---

## 3. como usarlo 

pizarra fue creado para ser usado manera intuitiva al inicio en la parte superior derecha de sus pantallas podran observar un boton de registro y un boton de ingreso, si creas una cuenta nueva te dara la obcion de crear un equipo u unirte a uno (se te asignaran el rol de lider o trabajador respectivamente), posteriormente podras encontrar una interfaz donde te puedes ver tus equipos informacion de tu cuenta, opcion de crear un quipo o unirse a otro y tu perfil desde el cual podras editar la informacion de tu cuennta como lo son nombre correo y contraseña, asi mismo cuando eres lider puedes gestionar tus equipos, permitiendote dar roles a los trabajadores que tengas en ellos, asignado tareas ,editando tareas y demas (cuando este dentro de trabajar en un equipo especifico para regresar a la pagina principa es tan simple como como dar clik en mis equipos en la parte superior derecha de sus pantallas), pizarra tambien implementa un tablero kanban el cual te permite posicionar las tareas en un derterminado punto de el desarrollo (por hacer, en progreso, terminada), para cambiar una tareas de por hacer a en progreso es tan simple como arrastrar esa tarea hacia la columna de en progreso y haci para con todas las tareas que tengas.
---

