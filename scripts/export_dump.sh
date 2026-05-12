#!/usr/bin/env bash
set -euo pipefail

DB_USER=${1:-root}
DB_PASS=${2:-}
DB_NAME=${3:-airarg_db}
OUT=${4:-dump.sql}

if [ -n "${DB_PASS}" ]; then
  mysqldump -u"${DB_USER}" -p"${DB_PASS}" "${DB_NAME}" > "${OUT}"
else
  mysqldump -u"${DB_USER}" "${DB_NAME}" > "${OUT}"
fi

echo "Dump saved to ${OUT}"
