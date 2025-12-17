# Entornos Graficos - TP

## Requisitos Previos

- Docker Desktop instalado y en ejecución
- Puertos 80 y 8080 disponibles en tu sistema

## Pasos para Ejecutar la Aplicación

### 1. Clonar el Repositorio

```bash
git clone <url-del-repositorio>
cd E.G.-TP
```

### 2. Iniciar los Contenedores

Ejecuta el siguiente comando en la raíz del proyecto:

```bash
docker-compose up -d
```

Este comando iniciará tres servicios:
- **Apache + PHP + MySQLi**: Servidor web de la aplicación
- **MySQL**: Base de datos
- **phpMyAdmin**: Interfaz web para administrar la base de datos

### 3. Acceder a la Aplicación

Una vez que los contenedores estén corriendo:

- **Aplicación Web**: [http://localhost](http://localhost)
- **phpMyAdmin**: [http://localhost:8080](http://localhost:8080)

### 4. Configuración de la Base de Datos

La aplicación se conecta automáticamente a la base de datos con las siguientes credenciales:

- **Host**: mysql
- **Usuario**: root
- **Contraseña**: pw
- **Base de datos**: tp entornos

La base de datos se almacena en la carpeta `DB/` del proyecto.

## Detener la Aplicación

Para detener los contenedores:

```bash
docker-compose down
```

## Notas

- La carpeta `DB/` contiene los datos persistentes de MySQL
- Los archivos del proyecto se montan directamente en el contenedor, por lo que los cambios en el código se reflejan automáticamente