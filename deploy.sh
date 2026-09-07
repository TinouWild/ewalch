#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "${BASH_SOURCE[0]}")"

REMOTE_HOST="ubuntu@217.182.71.207"
REMOTE_DIR="/stacks/ewalch"
COMPOSE_FILE="docker-compose.yml"
SERVICE="ewalch_php"
IMAGE="ewalch-prod_php"

TAG="${1:-$(cat .last_build 2>/dev/null || true)}"
if [ -z "${TAG}" ]; then
    echo "Usage: $0 [tag]  (or run ./build.sh first to set .last_build)" >&2
    exit 1
fi

ARCHIVE="ewalch_${TAG}.tar.zst"
[ -f "${ARCHIVE}" ] || { echo "Archive not found: ${ARCHIVE}" >&2; exit 1; }

# scp -rp ./app/public/ "${REMOTE_HOST}:${REMOTE_DIR}/storage/app/"

CONTROL_PATH="/tmp/ewalch-deploy-%r@%h:%p"
SSH_OPTS=(-o "ControlMaster=auto" -o "ControlPath=${CONTROL_PATH}" -o "ControlPersist=60s")
trap 'ssh "${SSH_OPTS[@]}" -O exit "${REMOTE_HOST}" 2>/dev/null || true' EXIT

echo "==> Copying ${ARCHIVE} to ${REMOTE_HOST}:${REMOTE_DIR}/"
scp "${SSH_OPTS[@]}" "${ARCHIVE}" "${REMOTE_HOST}:${REMOTE_DIR}/"

echo "==> Loading image and restarting ${SERVICE}"
ssh "${SSH_OPTS[@]}" "${REMOTE_HOST}" bash -s <<EOF
set -euo pipefail
cd "${REMOTE_DIR}"

command -v zstd >/dev/null || { echo "zstd is not installed on the server (apt install zstd)" >&2; exit 1; }

zstd -d --stdout "${ARCHIVE}" | docker load
docker compose -f "${COMPOSE_FILE}" up -d "${SERVICE}"

rm -f "${ARCHIVE}"
docker image prune -f >/dev/null

# keep only the 3 most recent versioned tags of ${IMAGE} (latest is always kept)
docker images "${IMAGE}" --format '{{.CreatedAt}}|{{.Tag}}' \
    | grep -v '|latest\$' \
    | sort -r \
    | tail -n +4 \
    | cut -d'|' -f2 \
    | xargs -r -I{} docker rmi "${IMAGE}:{}"
EOF

echo "==> Deployed ${IMAGE}:${TAG} as latest, ${SERVICE} restarted"
