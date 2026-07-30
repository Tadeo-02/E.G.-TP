#!/bin/bash
set -e

DIR="$(cd "$(dirname "$0")" && pwd)"

echo "============================================"
echo "  Tests de regresion — Refactor PHP"
echo "============================================"
echo ""

total=0
fallos=0

for test in "$DIR"/test_*.php; do
    nombre=$(basename "$test" .php)
    echo ">> Ejecutando $nombre..."
    if php "$test"; then
        echo ""
        echo "   $nombre: OK"
    else
        echo ""
        echo "   $nombre: FALLO"
        fallos=$((fallos + 1))
    fi
    echo "--------------------------------------------"
    echo ""
    total=$((total + 1))
done

echo "============================================"
if [ $fallos -eq 0 ]; then
    echo "  Todos los tests pasaron ($total/$total)"
else
    echo "  $fallos/$total tests fallaron"
fi
echo "============================================"
exit $fallos
