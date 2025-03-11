# Comnado de GIT (Iniciales)
## Requerimientos
- Descargar GIT
- Crear una cuenta en GITHUB

## Configurar GIT
-ejecutar los siguientes comandos por primera vez cuando se instala git
....
git config --global user.name "Su nombre"
git config --global user.email "Su email"
...

## Comando Iniciales
## Crear un repositorio en GITHUB ()
## Inicializar un repositorio Local
...
git init
...

## Referencia del repositorio (local) al repositorio (remoto)
...
git remote add origin https://github.com/stevsan84/backend_laravel_vue_proyecto.git
...

## Actualizar el repositorio
...
git add .
git commit -m "Proyecto Base (CRUD Usuarios)"
git push origin master
...

## Obtener los nuevos cambios
...
git pull origin master
...