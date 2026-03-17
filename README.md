# Tema Pawtucket2 — FFyL UBA (filo)

Tema de CollectiveAccess Pawtucket2 adaptado visualmente al sitio institucional de la
[Facultad de Filosofía y Letras de la UBA](https://filo.uba.ar).

---

## Instalación

1. Copiar la carpeta `filo` (o el contenido de este repositorio) a:
   ```
   /path/to/pawtucket2/themes/filo/
   ```
2. En `setup.php` de Pawtucket2, configurar:
   ```php
   define('__CA_THEME__', 'filo');
   ```
3. Copiar la vista del plugin FindingAid al directorio del plugin:
   ```bash
   mkdir -p /path/to/pawtucket2/app/plugins/FindingAid/themes/filo/views/
   cp plugins/FindingAid/views/index_html.php \
      /path/to/pawtucket2/app/plugins/FindingAid/themes/filo/views/
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

---

## Orden de presentación de Fondos y Colecciones

El orden en que aparecen los fondos en la página `/FindingAid/Collection/Index`
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

-- Insertar la restricción de tipo (reemplazar 208 por el type_id de Fondo
-- y 125 por el type_id de Colección si también se quiere en colecciones)
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
**"Colección Orden de presentación"** a la columna derecha ("Elementos que mostrar").

#### 4. Asignar permisos

En el mismo elemento de metadatos, en la sección **Role access**,
asignar al menos **"puede editar"** al rol **Administrators**.

#### 5. Asignar valores

Abrir cada fondo en Providence y asignar un número en el campo
"Orden de presentación":
- `1` → primer fondo a mostrar
- `2` → segundo fondo
- etc.

Los fondos sin número asignado aparecerán al final automáticamente.

---

## Traducciones (locale)

El tema incluye un archivo de locale en `locale/es_ES/messages.po`.
Después de modificarlo, compilar en el servidor:

```bash
cd /path/to/themes/filo/locale/es_ES
msgfmt --check messages.po -o messages.mo
```

Luego borrar la caché de traducciones:

```bash
rm /path/to/pawtucket2/app/tmp/ca_translation*
rm /path/to/pawtucket2/app/tmp/caCompiledView*
```

---

## Orden de facets en Browse

Los labels de los facets del browse (panel lateral y menú desplegable)
se configuran en `conf/browse.conf`. Los valores actuales están hardcodeados
en español directamente en el archivo (no via locale) porque el parser interno
de CA los lee antes del sistema de traducción.

---

## Logo

El logo generado programáticamente está en:
`assets/pawtucket/graphics/filo_logo.png`

Para reemplazarlo con el logo oficial:
```bash
wget https://filo.uba.ar/themes/contrib/fedro-theme/logo.png \
     -O assets/pawtucket/graphics/filo_logo.png
```

---

## Archivos clave modificados

| Archivo | Descripción |
|---|---|
| `assets/pawtucket/css/theme.css` | Hoja de estilos principal |
| `views/pageFormat/pageHeader.php` | Encabezado con 3 bandas |
| `views/pageFormat/pageFooter.php` | Pie de página azul oscuro |
| `conf/browse.conf` | Configuración de facets y browse |
| `conf/FindingAid.conf` | Configuración de Fondos y Colecciones |
| `plugins/FindingAid/views/index_html.php` | Vista del listado de fondos (con sort manual) |
| `locale/es_ES/messages.po` | Traducciones al español |
| `views/Browse/browse_results_html.php` | Vista de resultados del browse |
