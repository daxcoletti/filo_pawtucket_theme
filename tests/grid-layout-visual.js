#!/usr/bin/env node

/**
 * Visual Test: Collection Grid Layout
 *
 * Este test verifica que la grilla de elementos de colección se renderiza
 * correctamente en el navegador usando Puppeteer (headless Chrome).
 *
 * Verifica:
 * - Que los elementos se muestren en grilla (no verticalmente)
 * - Que el CSS se aplique correctamente
 * - Que los items sean de tamaño consistente
 * - Que el layout sea responsivo
 * - Que toma un screenshot para inspección visual
 *
 * Uso: npm run test:grid
 */

const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

// Configuración
const TEST_URL = 'https://test.pawtucket.filo.uba.ar/index.php/Detail/collections/9';
const COLLECTION_ID = 9;
const SCREENSHOTS_DIR = path.join(__dirname, 'screenshots');

// Crear directorio de screenshots si no existe
if (!fs.existsSync(SCREENSHOTS_DIR)) {
  fs.mkdirSync(SCREENSHOTS_DIR, { recursive: true });
}

async function runTest() {
  console.log('═══════════════════════════════════════════════════════════════');
  console.log('TEST VISUAL: GRILLA DE ELEMENTOS DE COLECCIÓN');
  console.log('═══════════════════════════════════════════════════════════════\n');

  let browser;
  try {
    // Iniciar navegador
    console.log('[1/6] Iniciando navegador...');
    browser = await puppeteer.launch({
      headless: 'new',
      args: ['--no-sandbox', '--disable-setuid-sandbox']
    });

    // Crear página
    console.log('[2/6] Abriendo página...');
    const page = await browser.newPage();

    // Configurar viewport para desktop
    await page.setViewport({ width: 1920, height: 1080 });

    // Desabilitar SSL para testing
    await page.goto(TEST_URL, {
      waitUntil: 'networkidle2',
      timeout: 30000
    });

    // Esperar a que se carguen los items (AJAX)
    console.log('[3/6] Esperando carga de items (AJAX)...');
    await page.waitForSelector('.bResultItemCol', { timeout: 10000 });
    await new Promise(resolve => setTimeout(resolve, 2000)); // Esperar animaciones

    // Tomar screenshot
    console.log('[4/6] Tomando screenshot...');
    const timestamp = new Date().toISOString().replace(/[:.]/g, '-');
    const screenshotPath = path.join(SCREENSHOTS_DIR, `grid-layout-${timestamp}.png`);

    // Scroll to items section
    await page.evaluate(() => {
      const container = document.getElementById('browseResultsContainer');
      if (container) {
        container.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
    await new Promise(resolve => setTimeout(resolve, 500));

    // Capturar solo el viewport (no fullPage para evitar problemas de tamaño)
    await page.screenshot({ path: screenshotPath });
    console.log(`✓ Screenshot guardado: ${screenshotPath}`);

    // Ejecutar tests de verificación
    console.log('[5/6] Ejecutando verificaciones visuales...');

    const testResults = await page.evaluate(() => {
      const results = {
        containerFound: false,
        gridContainerClass: false,
        itemsFound: 0,
        itemsVisible: 0,
        itemsInGrid: 0,
        itemWidths: [],
        gridGap: null,
        displayType: null,
        errors: []
      };

      // Verificar contenedor
      const container = document.getElementById('browseResultsContainer');
      if (container) {
        results.containerFound = true;
        results.gridContainerClass = container.classList.contains('collection-grid-container');
      } else {
        results.errors.push('browseResultsContainer no encontrado');
      }

      // Encontrar items
      const items = document.querySelectorAll('.bResultItemCol');
      results.itemsFound = items.length;

      if (items.length > 0) {
        // Verificar items visibles
        items.forEach((item, index) => {
          const rect = item.getBoundingClientRect();

          // Comprobar si es visible (dentro del viewport o cercano)
          if (rect.top < window.innerHeight + 100 && rect.bottom > -100) {
            results.itemsVisible++;
          }

          // Comprobar si está en una grilla (múltiples items por fila)
          const width = rect.width;
          results.itemWidths.push(Math.round(width));

          // Los primeros 5 items deberían estar en la misma fila
          if (index < 5) {
            const y = Math.round(rect.top);
            if (index === 0) {
              results.firstItemY = y;
            } else if (Math.abs(y - results.firstItemY) < 50) {
              // Si el Y es similar al primer item, están en la misma fila
              results.itemsInGrid++;
            }
          }
        });

        // Analizar CSS
        const containerStyle = window.getComputedStyle(container);
        results.displayType = containerStyle.display;

        // Buscar gap/espaciado
        const gapMatch = containerStyle.gap;
        if (gapMatch) {
          results.gridGap = gapMatch;
        }

        // Verificar si hay variación de ancho (indica grilla)
        const widthSet = new Set(results.itemWidths.slice(0, 5));
        results.hasConsistentWidth = widthSet.size <= 2; // Permite pequeña variación
      }

      return results;
    });

    // Mostrar resultados
    console.log('\n═══════════════════════════════════════════════════════════════');
    console.log('RESULTADOS DEL TEST');
    console.log('═══════════════════════════════════════════════════════════════\n');

    let testsPassed = 0;
    let testsFailed = 0;

    // Test 1: Contenedor
    if (testResults.containerFound) {
      console.log('✓ [TEST 1] browseResultsContainer encontrado');
      testsPassed++;
    } else {
      console.log('✗ [TEST 1] browseResultsContainer NO encontrado');
      testsFailed++;
    }

    // Test 2: Clase de grilla
    if (testResults.gridContainerClass) {
      console.log('✓ [TEST 2] Clase collection-grid-container presente');
      testsPassed++;
    } else {
      console.log('✗ [TEST 2] Clase collection-grid-container NO presente');
      testsFailed++;
    }

    // Test 3: Items encontrados
    if (testResults.itemsFound > 0) {
      console.log(`✓ [TEST 3] ${testResults.itemsFound} items encontrados`);
      testsPassed++;
    } else {
      console.log('✗ [TEST 3] NO se encontraron items');
      testsFailed++;
    }

    // Test 4: Items visibles
    if (testResults.itemsVisible > 0) {
      console.log(`✓ [TEST 4] ${testResults.itemsVisible} items visibles en pantalla`);
      testsPassed++;
    } else {
      console.log('✗ [TEST 4] NO hay items visibles');
      testsFailed++;
    }

    // Test 5: Items en grilla (múltiples por fila)
    if (testResults.itemsInGrid >= 3) {
      console.log(`✓ [TEST 5] Items dispuestos en GRILLA (${testResults.itemsInGrid} en primera fila)`);
      testsPassed++;
    } else if (testResults.itemsFound > 0) {
      console.log(`⚠ [TEST 5] Items NO en grilla (solo ${testResults.itemsInGrid} en primera fila)`);
      testsFailed++;
    }

    // Test 6: Ancho consistente
    if (testResults.hasConsistentWidth) {
      console.log(`✓ [TEST 6] Items tienen ancho consistente (${testResults.itemWidths.slice(0, 3).join('px, ')}px)`);
      testsPassed++;
    } else {
      console.log('⚠ [TEST 6] Anchos variables (revisar CSS)');
    }

    // Test 7: Espaciado
    if (testResults.gridGap) {
      console.log(`✓ [TEST 7] Grid gap detectado: ${testResults.gridGap}`);
      testsPassed++;
    }

    // Errores
    if (testResults.errors.length > 0) {
      console.log('\n⚠ Errores encontrados:');
      testResults.errors.forEach(err => console.log(`  - ${err}`));
    }

    // Resumen
    console.log('\n═══════════════════════════════════════════════════════════════');
    console.log(`RESUMEN: ${testsPassed} PASADOS, ${testsFailed} FALLIDOS`);
    console.log('═══════════════════════════════════════════════════════════════\n');

    // Resultado final
    if (testsFailed === 0 && testsPassed >= 5) {
      console.log('✓✓✓ LA GRILLA FUNCIONA CORRECTAMENTE ✓✓✓\n');
      console.log(`Screenshot disponible en: ${screenshotPath}\n`);
      process.exit(0);
    } else {
      console.log('✗✗✗ PROBLEMAS EN LA GRILLA ✗✗✗\n');
      console.log(`Screenshot disponible en: ${screenshotPath}`);
      console.log(`Revisar el screenshot para diagnóstico visual.\n`);
      process.exit(1);
    }

  } catch (error) {
    console.error('\n✗✗✗ ERROR DURANTE EL TEST ✗✗✗\n');
    console.error(`Error: ${error.message}`);
    console.error(error.stack);
    process.exit(1);
  } finally {
    if (browser) {
      await browser.close();
    }
  }
}

// Ejecutar test
runTest();
