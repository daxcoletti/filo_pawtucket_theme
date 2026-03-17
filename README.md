# Tema Pawtucket2 — Archivo FFyL UBA

Tema de CollectiveAccess Pawtucket2 para el repositorio digital del
[Archivo de la Facultad de Filosofía y Letras de la UBA](https://filo.uba.ar).

![CollectiveAccess](https://img.shields.io/badge/CollectiveAccess-Pawtucket2-blue)
![Tema](https://img.shields.io/badge/Tema-FFyL%20UBA-1a2035)

---

## Instalación en un servidor nuevo

### 1. Clonar el repositorio

```bash
cd /opt/collectiveaccess/pawtucket2/themes/
git clone https://github.com/daxcoletti/filo_pawtucket_theme.git filo
```

### 2. Configurar el tema en Pawtucket2

En `setup.php` de Pawtucket2:
```php
define('__CA_THEME__', 'filo');
```

### 3. Symlink del plugin FindingAid

El archivo `plugins/FindingAid/views/index_html.php` vive en el repo.
El plugin lo necesita en su propio directorio — se resuelve con un symlink
que solo hay que crear una vez:

```bash
mkdir -p /opt/collectiveaccess/pawtucket2/app/plugins/FindingAid/themes/filo/views/

ln -s /opt/collectiveaccess/pawtucket2/themes/filo/plugins/FindingAid/views/index_html.php \
      /opt/collectiveaccess/pawtucket2/app/plugins/FindingAid/themes/filo/views/index_html.php
```

Verificar:
```bash
ls -la /opt/collectiveaccess/pawtucket2/app/plugins/FindingAid/themes/filo/views/
```

### 4. Compilar las traducciones

```bash
cd /opt/collectiveaccess/pawtucket2/themes/filo/locale/es_ES
msgfmt --check messages.po -o messages.mo
```

### 5. Habilitar MultiSearch

```bash
echo "ca_enable_multisearch = 1" >> /opt/collectiveaccess/pawtucket2/app/conf/app.conf
```

### 6. Configurar el campo "Orden de presentación" en la base de datos

Este campo controla el orden de los fondos en `/FindingAid/Collection/Index`.
**Debe configurarse manualmente en cada instalación nueva** porque depende
de IDs de la base de datos que varían entre instalaciones.

#### a) Crear el elemento de metadatos en Providence

En **Gestionar → Administración → Elementos de metadatos**, crear:

| Campo | Valor |
|---|---|
| Nombre | Orden de presentación |
| Código | `orden_presentacion` |
| Tipo de dato | Número entero (Integer) |

#### b) Vincular a ca_collections via SQL

```sql
-- 1. Verificar el type_id de los Fondos en esta instalación
SELECT DISTINCT ca_collections.type_id, ca_list_item_labels.name_singular
FROM ca_collections
LEFT JOIN ca_list_items ON ca_collections.type_id = ca_list_items.item_id
LEFT JOIN ca_list_item_labels ON ca_list_items.item_id = ca_list_item_labels.item_id
WHERE ca_collections.parent_id IS NULL;

-- 2. Insertar la restricción de tipo
-- (reemplazar 208 por el type_id de "Fondo" que devuelve la query anterior)
INSERT INTO ca_metadata_type_restrictions
  (table_num, type_id, element_id, settings, include_subtypes, rank)
SELECT 13, 208, element_id, 'YTowOnt9', 0, 0
FROM ca_metadata_elements
WHERE element_code = 'orden_presentacion';
```

> `table_num = 13` corresponde a `ca_collections`.
> El `type_id = 208` puede variar — verificar con la primera query.

#### c) Agregar a la interfaz de usuario de Providence

En **Gestionar → Administración → Interfaces de usuario → Collection editor**,
abrir la pantalla **"Identificación"** y arrastrar
**"Colección Orden de presentación"** a la columna derecha.

#### d) Asignar valores

Abrir cada fondo en Providence y asignar un número en "Orden de presentación":
`1` para el primero, `2` para el segundo, etc.
Los fondos sin número aparecerán al final automáticamente.

### 7. Limpiar caché

```bash
rm /opt/collectiveaccess/pawtucket2/app/tmp/caCompiledView*
rm /opt/collectiveaccess/pawtucket2/app/tmp/ca_translation*
```

---

## Actualizar desde GitHub

```bash
cd /opt/collectiveaccess/pawtucket2/themes/filo
git pull
rm /opt/collectiveaccess/pawtucket2/app/tmp/caCompiledView*
rm /opt/collectiveaccess/pawtucket2/app/tmp/ca_translation*
```

El symlink del plugin no necesita rehacerse — se actualiza solo con el `git pull`.

---

## Flujo de trabajo

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

Paleta basada en el sitio institucional [filo.uba.ar](https://filo.uba.ar):

| Elemento | Color |
|---|---|
| Navbar / Footer | `#1a2035` |
| Acento (teal) | `#2db5a3` |
| Tipografía | Open Sans + Lato |

### Fondo rotativo en página de inicio

Tres imágenes se alternan aleatoriamente en cada carga:
- `bg_bandera.jpg` — bandera institucional
- `bg_edificio.jpg` — edificio de Puán
- `bg_acta.jpg` — acta fundacional

Para agregar más imágenes: copiar el archivo a `assets/pawtucket/graphics/`
con el prefijo `bg_`, agregar la clase CSS en `theme.css` siguiendo el patrón
existente, y agregar el nombre al array en `views/Front/featured_set_slideshow_html.php`.

---

## Archivos clave

| Archivo | Descripción |
|---|---|
| `assets/pawtucket/css/theme.css` | Hoja de estilos principal |
| `assets/pawtucket/css/home_bibsite.css` | Estilos del carousel y buscador home |
| `assets/pawtucket/graphics/filo_logo.png` | Logo FFyL UBA |
| `assets/pawtucket/graphics/bg_*.jpg` | Imágenes de fondo rotativas |
| `views/pageFormat/pageHeader.php` | Encabezado con 3 bandas |
| `views/pageFormat/pageFooter.php` | Pie de página |
| `views/Front/featured_set_slideshow_html.php` | Hero + carousel de inicio |
| `views/About/Index.php` | Página "Acerca de" |
| `conf/browse.conf` | Configuración de facets y browse |
| `conf/FindingAid.conf` | Configuración de Fondos y Colecciones |
| `plugins/FindingAid/views/index_html.php` | Listado de fondos con orden manual |
| `locale/es_ES/messages.po` | Traducciones al español |
| `views/Browse/browse_results_html.php` | Vista de resultados del browse |
| `views/Search/multisearch_results_html.php` | Buscador general |

---

## Traducciones

Después de editar `locale/es_ES/messages.po`, compilar en el servidor:

```bash
cd /opt/collectiveaccess/pawtucket2/themes/filo/locale/es_ES
msgfmt --check messages.po -o messages.mo
rm /opt/collectiveaccess/pawtucket2/app/tmp/ca_translation*
```
