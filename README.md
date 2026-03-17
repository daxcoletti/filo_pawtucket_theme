# Tema Pawtucket2 — FFyL UBA (filo)

Tema de CollectiveAccess Pawtucket2 adaptado visualmente al sitio institucional de la
[Facultad de Filosofía y Letras de la UBA](https://filo.uba.ar).

![CollectiveAccess](https://img.shields.io/badge/CollectiveAccess-Pawtucket2-blue)
![Tema](https://img.shields.io/badge/Tema-FFyL%20UBA-1a2744)
![Licencia](https://img.shields.io/badge/Licencia-GPL--3.0-red)

---

## Instalación (primera vez en el servidor)

### 1. Clonar el repositorio

```bash
cd /opt/collectiveaccess/pawtucket2/themes/
git clone https://github.com/daxcoletti/filo_pawtucket_theme.git filo
```

### 2. Configurar el tema en Pawtucket2

En `setup.php`:
```php
define('__CA_THEME__', 'filo');
```

### 3. Crear el symlink para el plugin FindingAid

El archivo `plugins/FindingAid/views/index_html.php` vive en el repo pero
el plugin lo necesita en su propio directorio. Se resuelve con un symlink:

```bash
mkdir -p /opt/collectiveaccess/pawtucket2/app/plugins/FindingAid/themes/filo/views/

ln -s /opt/collectiveaccess/pawtucket2/themes/filo/plugins/FindingAid/views/index_html.php \
      /opt/collectiveaccess/pawtucket2/app/plugins/FindingAid/themes/filo/views/index_html.php
```

Verificar que el symlink funciona:
```bash
ls -la /opt/collectiveaccess/pawtucket2/app/plugins/FindingAid/themes/filo/views/
```

---

## Actualizar el tema desde GitHub

Cada vez que haya cambios en el repositorio, en el servidor:

```bash
cd /opt/collectiveaccess/pawtucket2/themes/filo
git pull
```

Y borrar la caché de CA:
```bash
rm /opt/collectiveaccess/pawtucket2/app/tmp/caCompiledView*
rm /opt/collectiveaccess/pawtucket2/app/tmp/ca_translation*
```

> El symlink del plugin **no necesita rehacerse** — apunta al archivo del repo
> y se actualiza automáticamente con el `git pull`.

---

## Flujo de trabajo recomendado

```
Editar archivos localmente
        ↓
git add . && git commit -m "descripción"
        ↓
git push
        ↓
En el servidor: git pull
        ↓
rm app/tmp/caCompiledView* app/tmp/ca_translation*
```

---

## Diseño

El tema replica la identidad visual de [filo.uba.ar](https://filo.uba.ar):

| Variable | Valor |
|---|---|
| Azul oscuro (navbar, footer) | `#1a2744` |
| Rojo acento | `#c0392b` |
| Amarillo/dorado | `#f0c040` |
| Tipografía | Open Sans + Lato (Google Fonts) |

### Estructura del header
1. **Barra superior** — fondo gris claro `#f2f2f2`, buscador y login
2. **Banda del logo** — fondo blanco, logo a la izquierda, redes sociales a la derecha
3. **Navbar** — fondo `#1a2744`, borde inferior rojo `#c0392b`

### Fondo rotativo
En cada carga de página se elige aleatoriamente una de las dos imágenes de fondo
(`bg_bandera.jpg` o `bg_edificio.jpg`) con un overlay blanco semitransparente
para mantener la legibilidad del contenido.
Para cambiar la opacidad del overlay, editar el valor `0.82` en `theme.css`:
```css
background: rgba(255, 255, 255, 0.82);
```

---

## Orden de presentación de Fondos y Colecciones

El orden en que aparecen los fondos en `/FindingAid/Collection/Index`
se controla mediante un campo de metadatos personalizado llamado **`orden_presentacion`**
que debe configurarse manualmente en Providence.

### Configuración en Providence (primera vez)

#### 1. Crear el elemento de metadatos

En **Gestionar → Administración → Elementos de metadatos**, crear:

| Campo | Valor |
|---|---|
| Nombre | Orden de presentación |
| Código | `orden_presentacion` |
| Tipo de dato | Número entero (Integer) |

#### 2. Vincular a ca_collections mediante SQL

El vínculo a través de la UI de Providence puede fallar. La forma confiable es
ejecutar directamente en la base de datos:

```sql
-- Verificar que el elemento existe y obtener su element_id
SELECT element_id, element_code FROM ca_metadata_elements
WHERE element_code = 'orden_presentacion';

-- Verificar el type_id de los Fondos
SELECT DISTINCT ca_collections.type_id, ca_list_item_labels.name_singular
FROM ca_collections
LEFT JOIN ca_list_items ON ca_collections.type_id = ca_list_items.item_id
LEFT JOIN ca_list_item_labels ON ca_list_items.item_id = ca_list_item_labels.item_id
WHERE ca_collections.parent_id IS NULL;

-- Insertar la restricción de tipo
-- (reemplazar 208 por el type_id de Fondo que devuelve la query anterior)
INSERT INTO ca_metadata_type_restrictions
  (table_num, type_id, element_id, settings, include_subtypes, rank)
SELECT 13, 208, element_id, 'YTowOnt9', 0, 0
FROM ca_metadata_elements
WHERE element_code = 'orden_presentacion';
```

> **Nota:** `table_num = 13` corresponde a `ca_collections`.
> El `type_id = 208` puede variar según la instalación — verificar con la segunda query.

#### 3. Agregar a la interfaz de usuario

En **Gestionar → Administración → Interfaces de usuario → Collection editor**,
abrir la pantalla **"Identificación"** y arrastrar
**"Colección Orden de presentación"** a la columna derecha.

#### 4. Asignar permisos

En el elemento de metadatos, sección **Role access**,
asignar **"puede editar"** al rol **Administrators**.

#### 5. Asignar valores

Abrir cada fondo en Providence y asignar un número en "Orden de presentación":
- `1` → primer fondo a mostrar
- `2` → segundo fondo
- etc.

Los fondos sin número asignado aparecerán al final automáticamente.

---

## Traducciones (locale)

El tema incluye `locale/es_ES/messages.po`.
Después de modificarlo, compilar en el servidor:

```bash
cd /opt/collectiveaccess/pawtucket2/themes/filo/locale/es_ES
msgfmt --check messages.po -o messages.mo
```

Luego borrar la caché:
```bash
rm /opt/collectiveaccess/pawtucket2/app/tmp/ca_translation*
rm /opt/collectiveaccess/pawtucket2/app/tmp/caCompiledView*
```

---

## Orden de facets en Browse

Los labels de los facets se configuran en `conf/browse.conf`.
Los valores están hardcodeados en español directamente en el archivo
porque el parser interno de CA los lee antes del sistema de traducción.

---

## Logo

El logo está en `assets/pawtucket/graphics/filo_logo.png`.
Para reemplazarlo con el logo oficial:
```bash
wget https://filo.uba.ar/themes/contrib/fedro-theme/logo.png \
     -O /opt/collectiveaccess/pawtucket2/themes/filo/assets/pawtucket/graphics/filo_logo.png
```

---

## Archivos clave

| Archivo | Descripción |
|---|---|
| `assets/pawtucket/css/theme.css` | Hoja de estilos principal |
| `assets/pawtucket/graphics/bg_bandera.jpg` | Imagen de fondo 1 |
| `assets/pawtucket/graphics/bg_edificio.jpg` | Imagen de fondo 2 |
| `views/pageFormat/pageHeader.php` | Encabezado con 3 bandas |
| `views/pageFormat/pageFooter.php` | Pie de página azul oscuro |
| `conf/browse.conf` | Configuración de facets y browse |
| `conf/FindingAid.conf` | Configuración de Fondos y Colecciones |
| `plugins/FindingAid/views/index_html.php` | Vista del listado de fondos (con sort manual) |
| `locale/es_ES/messages.po` | Traducciones al español |
| `views/Browse/browse_results_html.php` | Vista de resultados del browse |
