# Tests para Filo Pawtucket Theme

Este directorio contiene tests automatizados para verificar que el tema funciona correctamente.

## Tests Disponibles

### Grid Layout Visual Test
**Archivo:** `grid-layout-visual.js`

Verifica que la grilla de elementos de colección se renderiza correctamente visualmente.

**Qué verifica:**
- ✅ Que el contenedor `browseResultsContainer` existe
- ✅ Que la clase `collection-grid-container` está presente
- ✅ Que los items se cargan (AJAX)
- ✅ Que los items son visibles en la página
- ✅ **Que los items se muestran en GRILLA (múltiples por fila), no verticalmente**
- ✅ Que el ancho de los items es consistente
- ✅ Que el espaciado entre items está presente

**Toma un screenshot** de la página para inspección visual manual.

## Instalación

### Requisitos
- Node.js 18+
- npm

### Pasos
```bash
cd tests
npm install
```

Esto instalará Puppeteer (headless Chrome), que es necesario para los tests visuales.

## Uso

### Ejecutar el test de grilla
```bash
npm run test:grid
```

O desde el directorio raíz del tema:
```bash
cd tests && npm run test:grid
```

### Salida esperada

**Si todo funciona:**
```
✓✓✓ LA GRILLA FUNCIONA CORRECTAMENTE ✓✓✓

Screenshot disponible en: screenshots/grid-layout-2026-04-29T08-24-30-123Z.png
```

**Si hay problemas:**
```
✗✗✗ PROBLEMAS EN LA GRILLA ✗✗✗

Screenshot disponible en: screenshots/grid-layout-2026-04-29T08-24-30-123Z.png
Revisar el screenshot para diagnóstico visual.
```

## Screenshots

Los screenshots se guardan en `tests/screenshots/` con un timestamp.

Puedes revisarlos para:
- Verificar visualmente que la grilla se ve bien
- Diagnosticar problemas de layout
- Documentar cambios en el UI

## Cómo funciona el test

1. **Abre un navegador headless** (Chrome sin interfaz gráfica)
2. **Carga la página de colección** (Collection #9)
3. **Espera a que se carguen los items** vía AJAX
4. **Toma un screenshot** de la página completa
5. **Ejecuta verificaciones JavaScript** en el navegador:
   - Cuenta items en pantalla
   - Mide anchos y posiciones
   - Verifica CSS y clases
   - Detecta si están en grilla (múltiples por fila)
6. **Genera reporte** con resultados

## Uso en futuras sesiones

### Verificar que los cambios al CSS funcionan
```bash
cd filo_pawtucket_theme/tests
npm run test:grid
```

### Después de actualizar el theme
```bash
# Pull los cambios
git pull

# Reinstalar dependencias (por si cambió Puppeteer)
npm install

# Correr test
npm run test:grid
```

### Troubleshooting

Si el test falla:

**Problema:** `Error: Failed to launch the browser process`
- **Solución:** Asegúrate de tener Node.js 18+ instalado
  ```bash
  node --version  # Debe ser >= v18.0.0
  ```

**Problema:** `Cannot find module 'puppeteer'`
- **Solución:** Ejecuta `npm install` en el directorio tests

**Problema:** `ECONNREFUSED` - No puede conectar al servidor
- **Solución:** Verifica que `https://test.pawtucket.filo.uba.ar` esté disponible

**Problema:** Items no aparecen en grilla en el screenshot
- **Solución:** Revisa el CSS en `assets/pawtucket/css/custom.css`
  - Asegúrate que tiene reglas para `.bResultItemCol`
  - Verifica que no haya reglas en conflicto en `assets/pawtucket/css/theme.css`

## Modificar el test

### Cambiar la URL a probar
Edita la variable `TEST_URL` en `grid-layout-visual.js`:
```javascript
const TEST_URL = 'https://test.pawtucket.filo.uba.ar/index.php/Detail/collections/9';
```

### Cambiar el viewport (tamaño de pantalla)
Edita las líneas:
```javascript
// Desktop (1920x1080)
await page.setViewport({ width: 1920, height: 1080 });

// Para mobile (320x667)
await page.setViewport({ width: 320, height: 667 });
```

### Agregar más verificaciones
Edita la función `page.evaluate()` para agregar más checks en JavaScript.

## Información técnica

**Herramientas usadas:**
- **Puppeteer 22.x** - Control de Chrome headless
- **Node.js** - Runtime para ejecutar tests

**Ventajas de este approach:**
- ✅ Verifica el resultado visual REAL, no solo el código
- ✅ Ejecuta JavaScript y espera a que se cargue AJAX
- ✅ Genera screenshots para inspección manual
- ✅ Rápido y sin interfaz gráfica
- ✅ Fácil de reproducir en CI/CD

**Limitaciones:**
- Solo funciona con el servidor disponible
- Necesita Node.js instalado
- El CSS debe estar correcto (no verifica CSS en sí, solo su aplicación visual)

## Historial de cambios

- **2026-04-29**: Creación inicial del test para verificar grid layout de elementos de colección
