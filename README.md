# 📦 Proyecto PHP + Apache con Docker

## 🔧 Instrucciones para obtener el digest actualizado de la imagen PHP

```bash
docker pull php:8.2-apache
docker inspect php:8.2-apache --format='{{index .RepoDigests 0}}'
```

💡 Copia el valor que obtengas y colócalo en tu Dockerfile para usar un FROM con hash más seguro:

```dockerfile
FROM php@sha256:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

## 🚀 Levantar el entorno Docker

```bash
docker-compose down
docker-compose up -d --build
```

Si necesitas iniciar un contenedor manualmente:

```bash
docker start <id_del_contenedor>
```

## 📂 Datos de conexión a la base de datos

- **Servidor:** db
- **Usuario:** admin
- **Contraseña:** claveultrasecreta
- **Base de datos:** mesa_de_partes

## 📌 Notas

- Asegúrate de que Docker esté corriendo antes de ejecutar los comandos.
- Si editas el Dockerfile, recuerda volver a ejecutar `docker-compose up -d --build` para aplicar los cambios.


## 📄 Visualización de Logs (Docker)

Puedes consultar los logs generados por la aplicación de distintas formas:

### 🐳 Desde el contenedor (modo en tiempo real recomendado)

```bash
docker exec -it <id_contenedor_web> bash
cd /var/www/html/logs
tail -f php_error.log
```

🔍 Esto te permitirá ver los eventos y errores registrados por PHP conforme ocurren.

---

### 🪟 Desde archivos locales (Windows / Explorador)

Gracias al volumen montado en `docker-compose.yml`, los archivos de logs también están disponibles localmente:

```
logs/php_error.log
```

Puedes abrirlo con cualquier editor o usar PowerShell:

```powershell
Get-Content .\logs\php_error.log -Wait
```

---

### 📝 Desde los logs estándar del contenedor

Para ver los mensajes que se imprimen directamente en consola por Apache o PHP:

```bash
docker-compose logs -f web
```

Esto es útil para revisar cualquier salida directa del contenedor `web`.

---

💡 Asegúrate de que la carpeta `logs/` exista y tenga permisos de escritura desde dentro del contenedor. Puedes crearla manualmente si es necesario:

```bash
mkdir logs
chmod 777 logs
```