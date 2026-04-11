#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "$0")" && pwd)"
SRC_DIR="$ROOT_DIR/xampp_php/"
DST_DIR="/Applications/XAMPP/xamppfiles/htdocs/xampp_php/"
CHECK_URL="http://127.0.0.1/xampp_php/public/index.php?page=home"

if [[ ! -d "$SRC_DIR" ]]; then
  echo "Error: no existe el origen $SRC_DIR" >&2
  exit 1
fi

if [[ ! -d "$DST_DIR" ]]; then
  echo "Error: no existe el destino $DST_DIR" >&2
  echo "Asegurate de tener XAMPP instalado y el proyecto en htdocs." >&2
  exit 1
fi

echo "Sincronizando archivos con rsync..."
rsync -a --delete "$SRC_DIR" "$DST_DIR"

echo "Verificando respuesta web..."
status_code="$(curl -s -o /tmp/airarg_deploy_check.html -w "%{http_code}" "$CHECK_URL")"

if [[ "$status_code" != "200" ]]; then
  echo "Advertencia: el deploy termino, pero la URL respondio $status_code" >&2
  exit 2
fi

echo "Deploy OK. URL activa: $CHECK_URL"